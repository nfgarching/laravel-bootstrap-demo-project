<?php

namespace App\Demo\ExamplePackage;

use Illuminate\Support\ServiceProvider;
use Nfgarching\Core\Modals\ModalRegistry;
use Nfgarching\Core\Navigation\NavbarNavigation;
use Nfgarching\Core\Navigation\SidebarNavigation;

/**
 * Pseudo-Feature-Package für die Registries-Demo. Es trägt einen Navbar-Eintrag,
 * einen Sidebar-Abschnitt und ein Modal bei – genau wie ein echtes Package.
 * Der when-Guard liest einen Session-Schalter, sodass sich alle drei Beiträge
 * auf /core/registries live ein- und ausblenden lassen.
 */
class ExampleServiceProvider extends ServiceProvider
{
    public const string SESSION_KEY = 'demo.example_package';

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/views', 'example');

        $active = fn (): bool => self::active();

        $this->app->make(NavbarNavigation::class)->item('example::navbar', order: 50, when: $active);

        $this->app->make(SidebarNavigation::class)->section('example::sidebar', order: 20, when: $active);

        $this->app->make(ModalRegistry::class)->modal('example::modal', order: 50, when: $active);
    }

    public static function active(): bool
    {
        return (bool) session(self::SESSION_KEY, true);
    }
}
