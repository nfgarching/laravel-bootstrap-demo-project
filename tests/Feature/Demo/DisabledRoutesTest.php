<?php

use App\Enums\DemoRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nfgarching\Core\Models\Prop;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->withoutVite();
    $this->admin = User::where('email', DemoRole::Admin->email())->firstOrFail();
});

it('blocks the destroy stub of the package', function () {
    $this->actingAs($this->admin)
        ->from('/props')
        ->delete('/props/1')
        ->assertRedirect('/props')
        ->assertSessionHas('message', 'In der Demo deaktiviert.');

    expect(Prop::find(1))->not->toBeNull();
});

it('blocks the action stub of the package', function () {
    $this->actingAs($this->admin)
        ->from('/props')
        ->get('/props/1/action')
        ->assertRedirect('/props')
        ->assertSessionHas('message', 'In der Demo deaktiviert.');
});

it('blocks the bulk delete of the props list', function () {
    $this->actingAs($this->admin)
        ->from('/props')
        ->post('/props', ['switchTo' => 'delete', 'checks' => [1, 2]])
        ->assertRedirect('/props')
        ->assertSessionHas('message', 'In der Demo deaktiviert.');

    expect(Prop::count())->toBe(40);
});

it('keeps the bulk change of the props list working', function () {
    $this->actingAs($this->admin)
        ->from('/props')
        ->post('/props', ['switchTo' => 'change', 'checks' => [1, 2], 'state' => 'error'])
        ->assertRedirect('/props');

    expect(Prop::whereKey([1, 2])->pluck('state')->unique()->all())->toBe(['error']);
});

it('rejects creating a prop without its parent model', function () {
    $this->actingAs($this->admin)
        ->from('/props/create')
        ->post('/props', ['key' => 'ohne_model'])
        ->assertRedirect('/props/create')
        ->assertSessionHas('message', 'Bitte model_type und model_id angeben.');

    expect(Prop::where('key', 'ohne_model')->exists())->toBeFalse();
});

it('shows a notice instead of the registration form', function () {
    $this->get('/register')
        ->assertOk()
        ->assertSee('Registrierung deaktiviert')
        ->assertDontSee('name="password_confirmation"', false);
});

it('does not register new users', function () {
    $this->post('/register', [
        'name' => 'Neu',
        'email' => 'neu@example.com',
        'password' => 'geheim-geheim',
        'password_confirmation' => 'geheim-geheim',
    ])->assertRedirect('/register');

    $this->assertGuest();
    expect(User::where('email', 'neu@example.com')->exists())->toBeFalse();
});

it('blocks profile updates and the package test pages', function (string $method, string $uri) {
    $this->actingAs($this->admin)
        ->from('/core/roles')
        ->call($method, $uri, ['name' => 'Umbenannt'])
        ->assertRedirect('/core/roles')
        ->assertSessionHas('message', 'In der Demo deaktiviert.');

    expect($this->admin->fresh()->name)->toBe('Demo Admin');
})->with([
    ['PUT', '/settings/3'],
    ['GET', '/testpage'],
    ['GET', '/testform'],
    ['GET', '/testing'],
]);

it('refuses the raw editor for models that are not released', function () {
    $this->actingAs($this->admin)
        ->from('/core/livewire')
        ->get('/raw?model='.urlencode(User::class).'&keyid=1')
        ->assertRedirect('/core/livewire')
        ->assertSessionHas('message', 'Dieses Model ist in der Demo nicht freigegeben.');
});

it('redirects the package welcome page to the demo home', function () {
    $this->get('/welcome')->assertRedirect('/');
});
