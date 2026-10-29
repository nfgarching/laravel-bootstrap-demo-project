<x-modal modid="demoCancelModal" title="button.cancel">
    <p class="mb-0">button.cancel schließt das Modal über data-bs-dismiss.</p>
    <x-slot:footer>
        <x-button.cancel />
        <x-button.cancel type="outline-danger" label="Verwerfen" />
    </x-slot:footer>
</x-modal>

<div class="d-flex flex-wrap gap-2 align-items-start">
    <x-button type="outline-primary" data-bs-toggle="modal" data-bs-target="#demoCancelModal">
        Modal mit button.cancel öffnen
    </x-button>

    <div class="border rounded p-2">
        <div class="small text-body-secondary mb-1">&lt;x-submit&gt;</div>
        <x-submit type="primary">Senden</x-submit>
    </div>
</div>
