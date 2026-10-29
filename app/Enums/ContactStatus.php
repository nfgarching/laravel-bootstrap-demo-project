<?php

namespace App\Enums;

/**
 * Status eines Demo-Kontakts; liefert label() und options() für die
 * Enum-Komponenten des Packages (wire.select-enum, table.filter.dropdown.enum).
 */
enum ContactStatus: string
{
    case Lead = 'lead';
    case Customer = 'customer';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Lead => 'Interessent',
            self::Customer => 'Kunde',
            self::Inactive => 'Inaktiv',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return array_column(
            array_map(fn (self $status): array => [$status->value, $status->label()], self::cases()),
            1,
            0,
        );
    }
}
