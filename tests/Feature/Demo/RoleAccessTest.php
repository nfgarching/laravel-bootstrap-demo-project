<?php

use App\Demo\RouteAccessMatrix;
use App\Enums\DemoRole;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Nfgarching\Core\Models\Prop;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->withoutVite();
});

function demoUser(DemoRole $role): User
{
    return User::where('email', $role->email())->firstOrFail();
}

it('applies the configured role groups to the package routes', function (string $uri, DemoRole $role, int $status) {
    $this->actingAs(demoUser($role))->get($uri)->assertStatus($status);
})->with([
    'admin as user' => ['/admin', DemoRole::User, 403],
    'admin as partner' => ['/admin', DemoRole::Partner, 403],
    'admin as admin' => ['/admin', DemoRole::Admin, 200],
    'dashboard as user' => ['/dashboard', DemoRole::User, 403],
    'dashboard as partner' => ['/dashboard', DemoRole::Partner, 200],
    'dashboard as admin' => ['/dashboard', DemoRole::Admin, 200],
    'startpage as user' => ['/startpage', DemoRole::User, 200],
    'props as partner' => ['/props', DemoRole::Partner, 403],
    'props as admin' => ['/props', DemoRole::Admin, 200],
    'prop create as admin' => ['/props/create', DemoRole::Admin, 200],
    'prop show as admin' => ['/props/1', DemoRole::Admin, 200],
    'prop edit as admin' => ['/props/1/edit', DemoRole::Admin, 200],
]);

it('sends guests from protected package routes to the demo logins', function (string $uri) {
    $this->get($uri)->assertRedirect(route('demo.core.roles'));
})->with(['/admin', '/dashboard', '/startpage', '/props']);

it('sends signed-in users away from guest-only package routes', function () {
    $this->actingAs(demoUser(DemoRole::User))
        ->get('/login')
        ->assertRedirect(route('demo.core.roles'));
});

it('marks the reachable routes for the current role in the matrix', function () {
    $rows = collect(app(RouteAccessMatrix::class)->rows(demoUser(DemoRole::Partner)))->keyBy('name');

    expect($rows['dashboard']['accessible'])->toBeTrue()
        ->and($rows['dashboard']['group'])->toBe('partner')
        ->and($rows['admin']['accessible'])->toBeFalse()
        ->and($rows['core.props.index']['group'])->toBe('admin')
        ->and($rows['login']['accessible'])->toBeFalse()
        ->and($rows['core.props.destroy']['disabled'])->toBeTrue()
        ->and($rows['register']['overridden'])->toBeTrue();
});

it('lets the admin update a prop through the package controller', function () {
    $this->actingAs(demoUser(DemoRole::Admin))
        ->put('/props/1', ['model_type' => Contact::class, 'model_id' => 1, 'value' => 'Geändert'])
        ->assertRedirect('/props/1');

    expect(Prop::find(1)->value)->toBe('Geändert');
});
