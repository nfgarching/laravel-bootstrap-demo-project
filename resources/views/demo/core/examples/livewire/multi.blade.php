{{-- modal.multi lauscht auf openModalMulti und zeigt get_multi() des Models an --}}
<button type="button" class="btn btn-outline-dark" x-data
    @click="$dispatch('openModalMulti', { modelName: @js($contact::class), NR: {{ $contact->id }} })">
    <i class="bi bi-card-text"></i> Multi anzeigen
</button>
