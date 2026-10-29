<x-demo.page page="components">

    <x-slot:intro>
        {{ __('Alle Blade-Komponenten liegen unter resources/views/components des Packages und sind ohne Registrierung als x-core::… erreichbar; kurze Tags wie x-button deklariert jede Datei selbst im x-tags-Header. Jede Karte zeigt die Vorschau und den Blade-Code aus derselben Datei.') }}
    </x-slot:intro>

    @php
        $groups = [
            'buttons' => 'Buttons',
            'basics' => 'Card, Accordion, Dropdown, Tabs',
            'fields' => 'Formularfelder',
            'tabelle' => 'Tabelle',
            'listing' => 'Listing',
            'modals' => 'Modals',
            'anzeige' => 'Datenanzeige',
            'icon' => 'Icon und Counter',
        ];
    @endphp

    <nav class="mb-4" aria-label="{{ __('Sprungmarken') }}">
        <ul class="nav nav-pills small flex-wrap gap-1">
            @foreach ($groups as $anchor => $label)
                <li class="nav-item"><a class="nav-link border" href="#{{ $anchor }}">{{ __($label) }}</a></li>
            @endforeach
        </ul>
    </nav>

    <section id="buttons" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Buttons') }}</h2>
        <x-demo.example title="button (index, link)" view="demo.core.examples.buttons.index"
            :description="__('type nimmt jede Bootstrap-Variante; mit href entsteht ein Link-Button, mit click ein wire:click.')" />
        <x-demo.example title="button.cancel, submit" view="demo.core.examples.buttons.submit-cancel"
            :description="__('Hinweis: x-submit rendert derzeit zusätzlich einen festen „Submit“-Button (siehe docs/package-fixes.md).')" />
        <x-demo.example title="button.clipboard" view="demo.core.examples.buttons.clipboard"
            :description="__('Kopiert Text – optional zusätzlich als HTML – und zeigt eine Bestätigung oben rechts.')" />
        <x-demo.example title="button.dispatch" view="demo.core.examples.buttons.dispatch"
            :description="__('Klick sendet ein Livewire-Event, Shift-Klick öffnet href als Popup, Strg-Klick in einem neuen Tab.')" />
        <x-demo.example title="button.popup" view="demo.core.examples.buttons.popup" />
        <x-demo.example title="button.group" view="demo.core.examples.buttons.group" />
        <x-demo.example title="button.model" view="demo.core.examples.buttons.model" :data="['prop' => $prop]" />
    </section>

    <section id="basics" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Card, Accordion, Dropdown, Tabs') }}</h2>
        <x-demo.example title="card" view="demo.core.examples.basics.card" />
        <x-demo.example title="accordion, accordion.item" view="demo.core.examples.basics.accordion" />
        <x-demo.example title="dropdown, dropdown.list, dropdown.click, dropdown.sort" view="demo.core.examples.basics.dropdown"
            :livewire="true" :description="__('dropdown.click und dropdown.sort brauchen eine Livewire-Komponente; das Beispiel läuft in einer.')" />
        <x-demo.example title="nav.tabs, nav.item" view="demo.core.examples.basics.nav-tabs" />
    </section>

    <section id="fields" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Formularfelder') }}</h2>
        <p class="small text-body-secondary">
            {{ __('Drei Familien: field.html.default für klassische Formulare (name, old(), @@error), field.wire.default (Tags slim.*) und field.wire.float (Tags wire.*) für Livewire. Die wire-Felder erkennen selbst, ob die Komponente ein form- oder item-Objekt hat, und binden dann form.feld bzw. item.feld.') }}
        </p>
        <x-demo.example title="field.html.default – field, field.select, field.text" view="demo.core.examples.fields.html-default" />
        <x-demo.example title="field.wire.default – slim, slim.select, slim.text" view="demo.core.examples.fields.wire-default" :livewire="true" />
        <x-demo.example title="field.wire.float – wire.input, wire.select, wire.select-enum, wire.search, wire.text"
            view="demo.core.examples.fields.wire-float" :livewire="true"
            :description="__('wire.select-enum erwartet Enum-Cases mit label(); hier App\\Enums\\ContactStatus. wire.search ist laut Package noch unfertig und zeigt Debug-Text im Label.')" />
        <x-demo.example title="form.* – input, select, textarea, group, label, cancel, submit" view="demo.core.examples.fields.forms"
            :description="__('Floating Labels für klassische Formulare. docs/Format.md stuft form.* noch als in Entwicklung ein.')" />
    </section>

    <section id="tabelle" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Tabelle') }}</h2>
        <x-demo.example title="table, table.row, table.head.sort, table.filter.*" view="demo.core.examples.table.contacts"
            :data="compact('contacts', 'request', 'cities', 'statusEnum')"
            :description="__('Filterleiste (Suche, Dropdown, Enum, Bool, Anzahl pro Seite), sortierbare Köpfe über kyslik/column-sortable, Checkbox-Toggle im Kopf, aufklappbare Zweitzeile und Pagination. Die Filter senden ein GET-Formular ab.')" />
    </section>

    <section id="listing" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Listing') }}</h2>
        <x-demo.example title="listing.card.headerLeft, listing.table.*, listing.nodata, listing.empty"
            view="demo.core.examples.listing.contacts" livewire="demo.contact-listing"
            :description="__('Partials für Livewire-Listen mit ListingTrait: Kartenkopf mit Suche und Sortierung, Tabellenzeilen mit Zweitzeile, Pagination mit Seitengröße, Zustände „keine Daten“ und „leer“.')" />
    </section>

    <section id="modals" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Modals') }}</h2>
        <x-demo.example title="modal, modal.button" view="demo.core.examples.modals.index" />
        <x-demo.example title="modal.save" view="demo.core.examples.modals.save" :livewire="true"
            :description="__('Der Speichern-Button ruft saveModal() der umgebenden Livewire-Komponente auf.')" />
        <x-demo.example title="modal.switch" view="demo.core.examples.modals.switch" :livewire="true"
            :description="__('Inhalt je nach $modalSwitch; die übrigen Fälle (insert, update, search, select) binden Views der Anwendung ein.')" />
        <x-demo.example title="modal.msg" view="demo.core.examples.modals.msg" />
    </section>

    <section id="anzeige" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Datenanzeige') }}</h2>
        <x-demo.example title="show.info" view="demo.core.examples.display.show-info" :data="['contact' => $contact]"
            :description="__('Zeilen für geladene Relationen erscheinen automatisch; hier ist props geladen.')" />
        <x-demo.example title="show.item" view="demo.core.examples.display.show-item" :data="['prop' => $prop]" />
        <x-demo.example title="field.desc – desc, desc.group, desc.list" view="demo.core.examples.display.desc" />
    </section>

    <section id="icon" class="mb-5">
        <h2 class="h4 mb-3">{{ __('Icon und Counter') }}</h2>
        <x-demo.example title="icon, counter" view="demo.core.examples.display.icon-counter" />
    </section>

</x-demo.page>
