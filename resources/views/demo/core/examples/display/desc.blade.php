{{-- field.desc.*: x-desc.group (dl.row), x-desc (dt/dd), x-desc.list (Array) --}}
<div class="row">
    <div class="col-lg-6">
        <x-desc.group>
            <x-desc label="Name" value="Erika Mustermann" />
            <x-desc label="Kunde seit" :value="2019" />
            <x-desc label="Newsletter" :value="true" />
            <x-desc label="Slot">
                <span class="badge text-bg-success">aktiv</span>
            </x-desc>
        </x-desc.group>
    </div>
    <div class="col-lg-6">
        <x-desc.group size="sm">
            <x-desc label="size=sm" value="kleinere Schrift" />
        </x-desc.group>
        <x-desc.list :item="['iban' => 'DE00 0000 0000 0000 0000 00', 'label' => 'Privat', 'state' => 'verified', 'memo' => 'nur die ersten zwei']" :count="2" />
    </div>
</div>
