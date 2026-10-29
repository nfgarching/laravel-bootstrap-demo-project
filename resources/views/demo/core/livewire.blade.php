<x-demo.page page="livewire">

    <x-slot:intro>
        {{ __('Das Package registriert vier Livewire-Komponenten: counter sowie die Modals modal.raw, modal.field und modal.multi. Die drei Modals bindet das Layout auf jeder Seite ein (layout::parts.modals); geöffnet werden sie per Event – von Buttons des Packages oder per dispatch() aus eigenem Code.') }}
    </x-slot:intro>

    <div class="alert alert-secondary small" role="note">
        <i class="bi bi-shield-check"></i>
        {{ __('In der öffentlichen Demo sind modal.raw und modal.field durch Unterklassen ersetzt, die nur das Model App\Models\Contact (und bei modal.field nur einzelne Felder) zulassen; Löschen ist deaktiviert. Alle Daten werden täglich zurückgesetzt.') }}
    </div>

    <x-demo.example title="counter" view="demo.core.examples.livewire.counter"
        :description="__('Nfgarching\Core\Livewire\Counter – einfacher Zähler, der zusätzlich mit #[On(\'testing\')] auf ein Event hört.')" />
    <x-demo.example title="modal.raw (Raw)" view="demo.core.examples.livewire.raw" :data="['contact' => $contact]"
        :description="__('Generischer Datensatz-Editor: listet alle Spalten der Tabelle und speichert direkt ins Model.')" />
    <x-demo.example title="modal.field (Modals\Field)" view="demo.core.examples.livewire.field" :data="['contact' => $contact]"
        :description="__('Bearbeitet ein einzelnes Feld in einem großen Textfeld; Event openModalField mit modelClass, keyid und field.')" />
    <x-demo.example title="modal.multi (Modals\Multi)" view="demo.core.examples.livewire.multi" :data="['contact' => $contact]"
        :description="__('Nur-Lese-Ansicht für mehrzeilige Werte; ruft get_multi() am Model auf (hier App\Models\Contact::get_multi()).')" />

</x-demo.page>
