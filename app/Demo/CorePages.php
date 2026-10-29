<?php

namespace App\Demo;

/**
 * Zentrale Liste der Demo-Unterseiten von nfgarching/core – Quelle für
 * Sidebar, Übersichtskacheln und Seitenköpfe.
 */
class CorePages
{
    public const string REPOSITORY = 'https://github.com/nfgarching/laravel-bootstrap-core';

    /**
     * @return array<string, array{route: string, title: string, icon: string, summary: string, doc: string}>
     */
    public static function all(): array
    {
        return [
            'index' => [
                'route' => 'demo.core.index',
                'title' => 'Übersicht',
                'icon' => 'house',
                'summary' => 'Was das Package mitbringt und wie es installiert wird.',
                'doc' => 'README.md',
            ],
            'layout' => [
                'route' => 'demo.core.layout',
                'title' => 'App-Shell',
                'icon' => 'layout-wtf',
                'summary' => 'Navbar, Sidebar, Offcanvas, Toasts und das Override-Pattern.',
                'doc' => 'docs/layout.md',
            ],
            'components' => [
                'route' => 'demo.core.components',
                'title' => 'Komponenten',
                'icon' => 'grid-3x3-gap',
                'summary' => 'Galerie der Blade-Komponenten mit Vorschau und Quelltext.',
                'doc' => 'docs/komponenten-registrierung.md',
            ],
            'livewire' => [
                'route' => 'demo.core.livewire',
                'title' => 'Livewire',
                'icon' => 'lightning-charge',
                'summary' => 'Counter und die globalen Modals Raw, Field und Multi.',
                'doc' => 'README.md#livewire-komponenten',
            ],
            'registries' => [
                'route' => 'demo.core.registries',
                'title' => 'Registries',
                'icon' => 'diagram-3',
                'summary' => 'Wie Feature-Packages Navbar, Sidebar und Modals beitragen.',
                'doc' => 'docs/sidebar-navigation.md',
            ],
            'props' => [
                'route' => 'demo.core.props',
                'title' => 'Prop-Model',
                'icon' => 'tags',
                'summary' => 'Polymorphe Eigenschaften mit der CRUD-Oberfläche des Packages.',
                'doc' => 'README.md#prop-model',
            ],
            'roles' => [
                'route' => 'demo.core.roles',
                'title' => 'Login und Rollen',
                'icon' => 'shield-lock',
                'summary' => 'Demo-Logins und die Rollenprüfung der Package-Routen.',
                'doc' => 'docs/route-rollen.md',
            ],
        ];
    }

    /**
     * @return array{route: string, title: string, icon: string, summary: string, doc: string}
     */
    public static function find(string $key): array
    {
        return self::all()[$key];
    }

    public static function docUrl(string $path): string
    {
        return self::REPOSITORY.'/blob/main/'.$path;
    }
}
