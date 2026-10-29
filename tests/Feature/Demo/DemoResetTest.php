<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Nfgarching\Core\Models\Prop;

// migrate:fresh lässt sich nicht in der Transaktion von RefreshDatabase ausführen.
uses(DatabaseMigrations::class);

it('rebuilds the demo data and clears the cache', function () {
    $this->seed();
    Contact::query()->first()->update(['name' => 'Verändert']);
    Prop::query()->delete();
    Cache::put('demo-test', 'wert');

    $this->artisan('demo:reset')->assertSuccessful();

    expect(Contact::count())->toBe(10)
        ->and(Contact::where('name', 'Verändert')->exists())->toBeFalse()
        ->and(Prop::count())->toBe(40)
        ->and(User::role('admin')->count())->toBe(1)
        ->and(Cache::has('demo-test'))->toBeFalse();
});

it('is scheduled daily at four o clock in Berlin', function () {
    $event = collect(app(Schedule::class)->events())
        ->first(fn ($event) => str_contains($event->command, 'demo:reset'));

    expect($event)->not->toBeNull()
        ->and($event->expression)->toBe('0 4 * * *')
        ->and($event->timezone)->toBe('Europe/Berlin');
});
