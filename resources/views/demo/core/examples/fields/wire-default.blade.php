<div>
    {{-- field.wire.default (Tags slim.*): kompakte Felder ohne Label mit wire:model --}}
    <div class="row g-3">
        <div class="col-md-4">
            <x-slim field="name" label="Name" modifier="live" />
        </div>
        <div class="col-md-4">
            <x-slim.select field="city" modifier="live" :option="[
                'Musterstadt' => 'Musterstadt',
                'Beispielhausen' => 'Beispielhausen',
                'Testdorf' => 'Testdorf',
            ]" />
        </div>
        <div class="col-md-4">
            <x-slim.text field="memo" rows="2" modifier="blur" />
        </div>
    </div>

    <p class="small text-body-secondary mt-3 mb-0">
        Livewire-Zustand: name = „{{ $name }}“, city = „{{ $city }}“, memo = „{{ $memo }}“
    </p>
</div>
