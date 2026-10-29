{{-- button.raw: Klick öffnet modal.raw mit allen Spalten des Datensatzes,
     Shift öffnet /raw als Popup, Strg in neuem Tab (beides nur angemeldet) --}}
<div class="d-flex flex-wrap gap-2 align-items-center">
    <x-button.raw :item="$contact" label="RAW-Ansicht öffnen" />
    <span class="small text-body-secondary">{{ $contact->name }} (contacts #{{ $contact->id }})</span>
</div>
