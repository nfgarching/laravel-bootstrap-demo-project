<div class="d-flex flex-wrap gap-2">
    {{-- Klick: zentriertes Popup-Fenster · Strg-Klick: neuer Tab --}}
    <x-button.popup :href="route('demo.core.index')">
        <i class="bi bi-window-stack"></i> Popup öffnen
    </x-button.popup>

    <x-button.popup :href="route('demo.core.index')" popup="width=480,height=360" type="outline-primary">
        Kleines Popup (480×360)
    </x-button.popup>
</div>
