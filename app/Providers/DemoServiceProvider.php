<?php

namespace App\Providers;

use App\Livewire\Demo\ContactListing;
use App\Livewire\Demo\Playground;
use App\Livewire\Demo\SafeField;
use App\Livewire\Demo\SafeRaw;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Nfgarching\Core\Navigation\NavbarNavigation;
use Nfgarching\Core\Navigation\SidebarNavigation;

/**
 * Bindet die Demo-Anwendung in die App-Shell von nfgarching/core ein –
 * ausschließlich über die Registries des Packages, ohne es zu ändern.
 */
class DemoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->make(SidebarNavigation::class)->section('demo.navigation.sidebar', order: 10);

        $this->app->make(NavbarNavigation::class)->item('demo.navigation.navbar', order: 90);

        // Läuft nach dem LibraryServiceProvider (App-Provider booten nach den
        // Package-Providern) und ersetzt dessen Aliase durch abgesicherte Unterklassen.
        Livewire::component('modal.raw', SafeRaw::class);
        Livewire::component('modal.field', SafeField::class);

        Livewire::component('demo.playground', Playground::class);
        Livewire::component('demo.contact-listing', ContactListing::class);

        RateLimiter::for('demo-login', fn (Request $request): Limit => Limit::perMinute(10)->by($request->ip()));
    }
}
