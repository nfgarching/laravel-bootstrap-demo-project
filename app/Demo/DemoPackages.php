<?php

namespace App\Demo;

/**
 * Packages, die die Demo vorstellt oder künftig vorstellen wird.
 */
class DemoPackages
{
    /**
     * @return list<array{name: string, icon: string, summary: string}>
     */
    public static function upcoming(): array
    {
        return [
            ['name' => 'mailer', 'icon' => 'envelope', 'summary' => 'E-Mail-Verwaltung mit IMAP-Postfächern und Versand.'],
            ['name' => 'documents', 'icon' => 'file-earmark-text', 'summary' => 'Dokumentenverwaltung mit Vorlagen und Ablage.'],
            ['name' => 'claims', 'icon' => 'cash-coin', 'summary' => 'Verwaltung von Forderungen.'],
        ];
    }
}
