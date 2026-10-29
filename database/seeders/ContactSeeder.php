<?php

namespace Database\Seeders;

use App\Enums\ContactStatus;
use App\Models\Contact;
use Illuminate\Database\Seeder;
use Nfgarching\Core\Models\Prop;

/**
 * Zehn Kontakte mit erfundenen Namen und 40 Props, die jede Kombination aus
 * state und type des Prop-Models mindestens einmal abdecken.
 */
class ContactSeeder extends Seeder
{
    /**
     * @var list<array{0: string, 1: string}>
     */
    private const array CONTACTS = [
        ['Erika Mustermann', 'Musterstadt'],
        ['Max Mustermann', 'Musterstadt'],
        ['Lieschen Müller', 'Beispielhausen'],
        ['Otto Normalverbraucher', 'Beispielhausen'],
        ['Paula Platzhalter', 'Testdorf'],
        ['Theo Testmann', 'Testdorf'],
        ['Frieda Fiktiv', 'Musterstadt'],
        ['Karl Kunstfigur', 'Beispielhausen'],
        ['Mia Musterfrau', 'Testdorf'],
        ['Hans Beispiel', 'Musterstadt'],
    ];

    private const array STATES = ['active', 'error', 'verified', 'unverified', 'pending'];

    private const array TYPES = ['birth_date', 'death_date', 'iban', 'metadata'];

    private const array LABELS = ['Privat', 'Geschäftlich', 'Import', 'Manuell'];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ContactStatus::cases();

        $contacts = collect(self::CONTACTS)->map(function (array $contact, int $index) use ($statuses): Contact {
            [$name, $city] = $contact;

            return Contact::create([
                'name' => $name,
                'email' => str($name)->lower()->ascii()->replace(' ', '.')->append('@example.com')->toString(),
                'city' => $city,
                'status' => $statuses[$index % count($statuses)],
                'newsletter' => $index % 2 === 0,
                'memo' => $index % 3 === 0 ? 'Erfundener Demo-Kontakt.' : null,
            ]);
        });

        foreach (range(0, 39) as $index) {
            $contact = $contacts[$index % $contacts->count()];
            $type = self::TYPES[$index % count(self::TYPES)];

            $contact->props()->create([
                'key' => "{$type}_".intdiv($index, count(self::TYPES)),
                'state' => self::STATES[$index % count(self::STATES)],
                'type' => $type,
                'label' => self::LABELS[$index % count(self::LABELS)],
                'value' => $this->valueFor($type, $index),
                'data' => $type === 'metadata' ? ['quelle' => 'Demo-Seeder', 'nummer' => $index] : null,
                'memo' => $index % 5 === 0 ? 'Automatisch erzeugter Demo-Eintrag.' : null,
            ]);
        }
    }

    /**
     * Erfundener Wert passend zum Prop-Typ; die IBAN ist absichtlich ungültig.
     */
    private function valueFor(string $type, int $index): string
    {
        return match ($type) {
            'birth_date' => now()->subYears(30 + $index)->startOfYear()->addDays($index * 7)->toDateString(),
            'death_date' => now()->subYears(1 + $index % 5)->startOfYear()->addDays($index * 5)->toDateString(),
            'iban' => sprintf('DE00 0000 0000 0000 0000 %02d', $index),
            default => "Metadaten #{$index}",
        };
    }
}
