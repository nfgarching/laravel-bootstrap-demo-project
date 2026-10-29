<?php

namespace App\Livewire\Demo;

use App\Models\Contact;
use Livewire\Attributes\On;
use Nfgarching\Core\Livewire\Raw;

/**
 * modal.raw des Packages, eingeschränkt auf freigegebene Demo-Models.
 *
 * Das Original lädt jede per Event oder Query übergebene Model-Klasse und
 * erlaubt Bearbeiten und Löschen – auf einer öffentlichen Seite auch für
 * App\Models\User. Siehe docs/package-fixes.md.
 */
class SafeRaw extends Raw
{
    /**
     * @var list<class-string>
     */
    public const array ALLOWED_MODELS = [Contact::class];

    public function mount(): void
    {
        if (request()->hasAny(['model', 'keyid']) && ! self::allows(request()->string('model')->toString())) {
            return;
        }

        parent::mount();
    }

    #[On('openModalRaw')]
    public function open(string $model = '', int|string $keyid = ''): void
    {
        if (! self::allows($model)) {
            $this->dispatch('show-message', message: __('Dieses Model ist in der Demo nicht freigegeben.'));

            return;
        }

        parent::open($model, $keyid);
    }

    public function deleteModal(): void
    {
        $this->dispatch('show-message', message: __('Löschen ist in der Demo deaktiviert.'));
    }

    public static function allows(string $model): bool
    {
        return in_array(ltrim($model, '\\'), self::ALLOWED_MODELS, true);
    }
}
