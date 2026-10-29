<div class="d-flex flex-wrap gap-2">
    <button type="button" class="btn btn-success"
        @click="$dispatch('show-toast', { title: 'Erfolg', subtitle: 'gerade eben', message: 'Der Datensatz wurde gespeichert.' })">
        <i class="bi bi-check-circle"></i> Toast: Erfolg
    </button>
    <button type="button" class="btn btn-warning"
        @click="$dispatch('show-toast', { title: 'Warnung', subtitle: 'bitte prüfen', message: 'Es fehlen noch Angaben.' })">
        <i class="bi bi-exclamation-triangle"></i> Toast: Warnung
    </button>
    <button type="button" class="btn btn-danger"
        @click="$dispatch('show-message', { message: 'Speichern fehlgeschlagen.' })">
        <i class="bi bi-x-octagon"></i> Meldung: Fehler
    </button>
    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark">
        <i class="bi bi-layout-sidebar-reverse"></i> Offcanvas öffnen
    </button>
</div>
