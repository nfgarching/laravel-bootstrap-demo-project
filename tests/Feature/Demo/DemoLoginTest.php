<?php

use App\Enums\DemoRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->withoutVite();
});

it('logs in the demo account of each role', function (DemoRole $role) {
    $this->post(route('demo.login', $role))
        ->assertRedirect(route('demo.core.roles'))
        ->assertSessionHas('message');

    $this->assertAuthenticated();
    expect(auth()->user()->email)->toBe($role->email())
        ->and(auth()->user()->hasRole($role->value))->toBeTrue();
})->with(DemoRole::cases());

it('rejects roles that are not demo roles', function () {
    $this->post('/demo/login/superadmin')->assertNotFound();

    $this->assertGuest();
});

it('does not offer the login via GET', function () {
    $this->get('/demo/login/admin')->assertMethodNotAllowed();
});

it('rate limits the demo login', function () {
    foreach (range(1, 10) as $attempt) {
        $this->post(route('demo.login', DemoRole::User))->assertRedirect();
    }

    $this->post(route('demo.login', DemoRole::User))->assertTooManyRequests();
});

it('never renders a password on the login pages', function () {
    $this->get(route('demo.core.roles'))
        ->assertDontSee('type="password"', false);
});
