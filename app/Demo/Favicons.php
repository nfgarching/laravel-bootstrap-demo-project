<?php

namespace App\Demo;

/**
 * Favicon-Varianten aus nfgarching/core/favicons. Je Umgebung ein anderes
 * Icon macht im Browser-Tab sofort sichtbar, wo man gerade arbeitet.
 */
class Favicons
{
    /**
     * Variante => Einsatzzweck.
     *
     * @var array<string, string>
     */
    public const array VARIANTS = [
        'default' => 'Produktion (neutral)',
        'Green' => 'Lokale Entwicklung',
        'Yellow' => 'Staging / Abnahme',
        'Blue' => 'Testumgebung',
        'Red' => 'Wartung oder Störung',
        'Black' => 'Archiv / schreibgeschützt',
    ];

    /**
     * Umgebung (APP_ENV) => Variante.
     *
     * @var array<string, string>
     */
    private const array ENVIRONMENTS = [
        'local' => 'Green',
        'staging' => 'Yellow',
        'testing' => 'Blue',
    ];

    public static function forEnvironment(string $environment): string
    {
        return self::ENVIRONMENTS[$environment] ?? 'default';
    }

    public static function path(string $variant): ?string
    {
        if (! array_key_exists($variant, self::VARIANTS)) {
            return null;
        }

        $file = $variant === 'default' ? 'favicon.ico' : "favicon{$variant}.ico";

        return base_path("vendor/nfgarching/core/favicons/{$file}");
    }
}
