<div>
    {{-- modal.save: Standard-Footer mit Abbrechen und Speichern (wire:click="saveModal") --}}
    <x-modal.save modid="demoSaveModal" title="Datensatz speichern" btnSaving="Übernehmen" type="primary">
        <x-slot:button><i class="bi bi-save"></i> modal.save öffnen</x-slot:button>

        <x-wire.input field="name" label="Name" />
    </x-modal.save>
</div>
