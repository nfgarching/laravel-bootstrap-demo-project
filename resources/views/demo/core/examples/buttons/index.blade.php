<div class="d-flex flex-wrap gap-2 mb-3">
    <x-button type="primary">Primary</x-button>
    <x-button type="secondary">Secondary</x-button>
    <x-button type="success">Success</x-button>
    <x-button type="danger">Danger</x-button>
    <x-button type="outline-primary">Outline</x-button>
    <x-button type="primary" :opacity="true">opacity</x-button>
</div>

<div class="d-flex flex-wrap gap-2">
    {{-- Ohne Slot und ohne label: Standardtext „Speichern“ --}}
    <x-button type="success" />
    <x-button type="info" label="Mit label" tooltip="Tooltip über data-bs-title" />
    {{-- Mit href wird ein <a class="btn"> gerendert --}}
    <x-button.link href="#ex-buttons-index" type="outline-secondary">
        <i class="bi bi-link-45deg"></i> Link
    </x-button.link>
</div>
