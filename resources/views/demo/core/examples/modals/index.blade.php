{{-- modal mit Slot button: Auslöse-Button und Modal in einem --}}
<x-modal modid="demoIndexModal" title="Einfaches Modal" type="outline-primary">
    <x-slot:button><i class="bi bi-window"></i> Modal öffnen</x-slot:button>

    Ohne footer-Slot zeigt das Modal einen Schließen-Button.
</x-modal>

{{-- Auslöser und Modal getrennt; class landet am .modal-dialog --}}
<x-modal.button modid="demoLargeModal" type="outline-secondary">Großes Modal</x-modal.button>

<x-modal modid="demoLargeModal" title="modal-lg mit eigenem Footer" class="modal-lg">
    Inhalt
    <x-slot:footer>
        <x-button.cancel label="Schließen" />
    </x-slot:footer>
</x-modal>
