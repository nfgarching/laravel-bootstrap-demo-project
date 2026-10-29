<?php

namespace App\Enums;

/**
 * Rollen der drei Demo-Konten (spatie/laravel-permission).
 */
enum DemoRole: string
{
    case User = 'user';
    case Partner = 'partner';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::User => 'User',
            self::Partner => 'Partner',
            self::Admin => 'Admin',
        };
    }

    /**
     * E-Mail-Adresse des Demo-Kontos dieser Rolle (reservierte Domain example.com).
     */
    public function email(): string
    {
        return "demo-{$this->value}@example.com";
    }

    /**
     * Bootstrap-Farbvariante für Badges und Buttons.
     */
    public function variant(): string
    {
        return match ($this) {
            self::User => 'secondary',
            self::Partner => 'info',
            self::Admin => 'danger',
        };
    }
}
