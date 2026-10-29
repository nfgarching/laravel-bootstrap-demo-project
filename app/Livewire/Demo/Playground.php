<?php

namespace App\Livewire\Demo;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Livewire-Wurzel für Beispiel-Partials, deren Package-Komponenten einen
 * Livewire-Kontext brauchen ($this, wire:model, wire:click). Rendert genau das
 * übergebene Partial – dieselbe Datei, die x-demo.example als Quelltext zeigt.
 */
class Playground extends Component
{
    private const string VIEW_PREFIX = 'demo.core.examples.';

    #[Locked]
    public string $view = '';

    public string $name = 'Erika Mustermann';

    public string $city = 'Musterstadt';

    public string $country = 'de';

    public string $status = 'lead';

    public string $memo = 'Freitext mit wire:model gebunden.';

    public string $search = '';

    public int $clicks = 0;

    public string $sortField = 'name';

    public bool $sortAsc = true;

    public string $modalName = 'demoSwitchModal';

    public string $modalTitle = 'modal.switch: editField';

    public string $modalSize = 'modal-lg';

    public string $modalSwitch = 'editField';

    public string $modalField = 'memo';

    public function mount(string $view): void
    {
        abort_unless(str_starts_with($view, self::VIEW_PREFIX), 404);

        $this->view = $view;
    }

    public function click(): void
    {
        $this->clicks++;

        $this->dispatch('show-message', message: __('wire:click ausgelöst (:count×)', ['count' => $this->clicks]));
    }

    public function sortBy(string $field): void
    {
        $this->sortAsc = $this->sortField === $field ? ! $this->sortAsc : true;
        $this->sortField = $field;
    }

    public function saveModal(): void
    {
        $this->dispatch('hide-modal', modalName: 'demoSaveModal');
        $this->dispatch('show-message', message: __('saveModal() aufgerufen – in der Demo wird nichts gespeichert.'));
    }

    public function render(): View
    {
        return view($this->view);
    }
}
