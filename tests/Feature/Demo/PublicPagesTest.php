<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->withoutVite();
});

it('renders every public demo page', function (string $routeName) {
    $this->get(route($routeName))->assertOk();
})->with([
    'demo.home',
    'demo.core.index',
    'demo.core.layout',
    'demo.core.components',
    'demo.core.livewire',
    'demo.core.registries',
    'demo.core.props',
    'demo.core.roles',
]);

it('renders the demo banner on every page', function () {
    $this->get(route('demo.home'))
        ->assertSee('Demo – alle Daten werden täglich zurückgesetzt.');
});

it('shows the demo login buttons to guests on protected demo pages', function (string $routeName) {
    $this->get(route($routeName))
        ->assertOk()
        ->assertSee('Als User anmelden')
        ->assertSee('Als Partner anmelden')
        ->assertSee('Als Admin anmelden');
})->with(['demo.core.props', 'demo.core.roles']);

it('filters and sorts the component table with query parameters', function () {
    $this->get(route('demo.core.components', ['city' => 'Testdorf', 'sort' => 'name', 'direction' => 'asc']))
        ->assertOk()
        ->assertSeeInOrder(['Mia Musterfrau', 'Paula Platzhalter', 'Theo Testmann'])
        ->assertDontSee('Max Mustermann</td>', false);
});

it('serves the favicon variants of the package', function () {
    $this->get(route('demo.favicon', 'Green'))
        ->assertOk()
        ->assertHeader('Content-Type', 'image/x-icon');

    $this->get('/favicons/Unbekannt.ico')->assertNotFound();
});

it('lists only package routes in the access matrix', function () {
    $this->get(route('demo.core.roles'))
        ->assertOk()
        ->assertSee('core.props.index')
        ->assertDontSee('demo.core.components');
});

it('hides the example package contributions when it is switched off', function () {
    $this->get(route('demo.core.registries'))
        ->assertSee('Eintrag aus der Registry')
        ->assertSee('id="exampleModal"', false);

    $this->post(route('demo.core.registries.toggle'))->assertRedirect(route('demo.core.registries'));

    $this->get(route('demo.core.registries'))
        ->assertDontSee('Eintrag aus der Registry')
        ->assertDontSee('id="exampleModal"', false)
        ->assertSee('Demo-Package aktivieren');
});
