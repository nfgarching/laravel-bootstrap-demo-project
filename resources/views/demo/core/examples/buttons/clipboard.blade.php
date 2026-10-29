<div class="d-flex flex-wrap gap-2">
    <x-button.clipboard text="DE00 0000 0000 0000 0000 00">
        <i class="bi bi-clipboard"></i> IBAN kopieren
    </x-button.clipboard>

    {{-- html: zusätzlich formatiert (text/html) in die Zwischenablage --}}
    <x-button.clipboard type="outline-primary" text="Erika Mustermann" html="<b>Erika</b> Mustermann"
        message="Name mit Formatierung kopiert">
        <i class="bi bi-type-bold"></i> Mit HTML kopieren
    </x-button.clipboard>
</div>
