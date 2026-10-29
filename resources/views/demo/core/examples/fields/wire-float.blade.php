<div>
    {{-- field.wire.float (Tags wire.*): Floating Labels mit wire:model --}}
    <div class="row g-3">
        <div class="col-md-6">
            <x-wire.input field="name" label="Name" modifier="live" />
        </div>
        <div class="col-md-6">
            <x-wire.select field="city" label="Ort" modifier="live" :options="[
                'Musterstadt' => 'Musterstadt',
                'Beispielhausen' => 'Beispielhausen',
                'Testdorf' => 'Testdorf',
            ]" />
        </div>
        <div class="col-md-6">
            <x-wire.select-enum field="status" label="Status (Enum)" modifier="live"
                :options="\App\Enums\ContactStatus::cases()" />
        </div>
        <div class="col-md-6">
            <x-wire.search field="search" label="Suche" modifier="live" />
        </div>
        <div class="col-12">
            <x-wire.text field="memo" label="Notiz" rows="3" modifier="blur" />
        </div>
    </div>

    <p class="small text-body-secondary mt-3 mb-0">
        Livewire-Zustand: name = „{{ $name }}“, city = „{{ $city }}“, status = „{{ $status }}“,
        search = „{{ $search }}“
    </p>
</div>
