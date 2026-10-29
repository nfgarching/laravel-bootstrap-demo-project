{{-- button.openModalField: öffnet modal.field und bearbeitet genau ein Feld --}}
<div class="d-flex flex-wrap gap-2 align-items-center">
    <x-button.openModalField :item="$contact" field="memo" label="Notiz bearbeiten" />
    <span class="small text-body-secondary">memo: „{{ $contact->memo }}“</span>
</div>
