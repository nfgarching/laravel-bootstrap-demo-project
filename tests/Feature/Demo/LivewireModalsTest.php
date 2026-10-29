<?php

use App\Livewire\Demo\SafeField;
use App\Livewire\Demo\SafeRaw;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

it('opens the raw modal for released models', function () {
    Livewire::test(SafeRaw::class)
        ->call('open', Contact::class, 1)
        ->assertSet('modelType', Contact::class)
        ->assertDispatched('show-modal', modalName: 'modalRAW');
});

it('refuses the raw modal for other models', function () {
    Livewire::test(SafeRaw::class)
        ->call('open', User::class, 1)
        ->assertSet('item', null)
        ->assertDispatched('show-message')
        ->assertNotDispatched('show-modal');
});

it('does not delete through the raw modal', function () {
    Livewire::test(SafeRaw::class)
        ->call('open', Contact::class, 1)
        ->call('deleteModal')
        ->assertDispatched('show-message');

    expect(Contact::find(1))->not->toBeNull();
});

it('saves released fields through the field modal', function () {
    Livewire::test(SafeField::class)
        ->call('open', Contact::class, 1, 'memo')
        ->set('value', 'Neue Notiz')
        ->call('saveModal');

    expect(Contact::find(1)->memo)->toBe('Neue Notiz');
});

it('refuses fields that are not released', function () {
    Livewire::test(SafeField::class)
        ->call('open', User::class, 1, 'password')
        ->assertSet('item', null)
        ->assertDispatched('show-message');

    Livewire::test(SafeField::class)
        ->call('open', Contact::class, 1, 'memo')
        ->set('field', 'email')
        ->set('value', 'manipuliert@example.com')
        ->call('saveModal');

    expect(Contact::find(1)->email)->not->toBe('manipuliert@example.com');
});

it('replaces the package aliases with the safe components', function () {
    $this->withoutVite()
        ->get(route('demo.core.livewire'))
        ->assertOk()
        ->assertSeeLivewire(SafeRaw::class)
        ->assertSeeLivewire(SafeField::class);
});
