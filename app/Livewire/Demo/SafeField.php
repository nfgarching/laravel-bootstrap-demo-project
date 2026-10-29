<?php

namespace App\Livewire\Demo;

use App\Models\Contact;
use Livewire\Attributes\On;
use Nfgarching\Core\Livewire\Modals\Field;

/**
 * modal.field des Packages, eingeschränkt auf freigegebene Models und Felder.
 *
 * Das Original schreibt in jedes Feld jedes übergebenen Models.
 * Siehe docs/package-fixes.md.
 */
class SafeField extends Field
{
    /**
     * @var array<class-string, list<string>>
     */
    public const array ALLOWED_FIELDS = [
        Contact::class => ['memo', 'name', 'city'],
    ];

    #[On('openModalField')]
    public function open(string $modelClass = '', int|string $keyid = 0, string $field = 'memo'): void
    {
        if (! self::allows($modelClass, $field)) {
            $this->dispatch('show-message', message: __('Dieses Feld ist in der Demo nicht freigegeben.'));

            return;
        }

        parent::open($modelClass, $keyid, $field);
    }

    public function saveModal(): void
    {
        if ($this->item === null || ! self::allows($this->item::class, $this->field)) {
            return;
        }

        parent::saveModal();

        $this->dispatch('show-message', message: __('Feld gespeichert.'));
    }

    public static function allows(string $modelClass, string $field): bool
    {
        return in_array($field, self::ALLOWED_FIELDS[ltrim($modelClass, '\\')] ?? [], true);
    }
}
