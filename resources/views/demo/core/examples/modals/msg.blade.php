{{-- modal.msg rendert die Modals #modalBestaetigung und #modalDatei. Das Layout
     bindet es bereits global ein (layout::parts.modals), deshalb hier nur die Auslöser. --}}
<div class="d-flex flex-wrap gap-2">
    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalBestaetigung">
        <i class="bi bi-trash3"></i> Bestätigung
    </button>
    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalDatei">
        <i class="bi bi-file-earmark"></i> Dokument anzeigen
    </button>
</div>
