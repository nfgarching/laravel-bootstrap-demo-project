<div>
    <div class="d-flex flex-wrap gap-3 align-items-start">

        {{-- dropdown: Button mit frei gestaltbarem, dunklem Menü --}}
        <x-dropdown label="<i class='bi bi-funnel'></i> dropdown" :toggle="true" width="16rem">
            <div class="px-3 py-2 small">Beliebiger Inhalt im Menü.</div>
        </x-dropdown>

        {{-- dropdown.list: Einträge aus option (href => Text) --}}
        <x-dropdown.list label="dropdown.list" :option="[
            route('demo.core.layout') => 'App-Shell',
            route('demo.core.livewire') => 'Livewire',
            route('demo.core.registries') => 'Registries',
        ]" />

        {{-- dropdown.click: wire:click auf eine Methode der Livewire-Komponente --}}
        <x-dropdown.list label="dropdown.click">
            <x-dropdown.click click="click">Methode click() aufrufen</x-dropdown.click>
            <x-dropdown.click click="click" confirm="Wirklich ausführen?">Mit wire:confirm</x-dropdown.click>
        </x-dropdown.list>

        {{-- dropdown.sort: ruft sortBy() und liest sortField/sortAsc der Komponente --}}
        <x-dropdown.list label="dropdown.sort">
            <x-dropdown.sort field="name" label="Name" :wire="$this" />
            <x-dropdown.sort field="city" label="Ort" :wire="$this" />
        </x-dropdown.list>

    </div>

    <p class="small text-body-secondary mt-3 mb-0">
        click(): {{ $clicks }}× · Sortierung: {{ $sortField }} {{ $sortAsc ? 'aufsteigend' : 'absteigend' }}
    </p>
</div>
