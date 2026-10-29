<div class="row g-3">
    <div class="col-lg-6">
        <x-card>
            <x-slot name="headerLeft"><strong>Kontakt</strong></x-slot>
            <x-slot name="headerRight">
                <x-button.link href="#ex-basics-card" type="outline-secondary" class="btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </x-button.link>
            </x-slot>

            Erika Mustermann, Musterstadt

            <x-slot name="footer">
                <small class="text-body-secondary">Slots: headerLeft, headerRight, footer</small>
            </x-slot>
        </x-card>
    </div>
    <div class="col-lg-6">
        {{-- Slot header ersetzt den kompletten Kartenkopf --}}
        <x-card class="border-primary">
            <x-slot name="header">
                <div class="card-header text-bg-primary">Eigener Kopf über den Slot header</div>
            </x-slot>
            Ohne headerLeft/headerRight zeigt die Karte Platzhaltertexte – deshalb hier header.
        </x-card>
    </div>
</div>
