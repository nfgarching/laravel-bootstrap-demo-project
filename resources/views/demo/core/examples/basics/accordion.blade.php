{{-- acc_id und row_id stabil wählen (nicht rand()), damit Livewire-Re-Renders
     die Zuordnung von Button und Collapse nicht zerstören. --}}
<x-accordion acc_id="demo-accordion">
    <x-accordion.item acc_id="demo-accordion" row_id="demo-acc-1" header="Was ist ein Prop?" :collapsed="false">
        Eine polymorphe Eigenschaft (key, state, type, value), die an jedes Model gehängt werden kann.
    </x-accordion.item>
    <x-accordion.item acc_id="demo-accordion" row_id="demo-acc-2" header="Welche Typen gibt es?">
        birth_date, death_date, iban und metadata.
    </x-accordion.item>
    <x-accordion.item acc_id="demo-accordion" row_id="demo-acc-3" header="Und die Status?">
        active, error, verified, unverified und pending.
    </x-accordion.item>
</x-accordion>
