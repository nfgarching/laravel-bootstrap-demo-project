<div class="row g-3 align-items-center">
    <div class="col-md-6">
        {{-- Klick: Livewire.dispatch('testing') · Shift: Popup · Strg: neuer Tab --}}
        <x-button.dispatch modalName="testing" :href="route('demo.core.components')">
            <i class="bi bi-broadcast"></i> Event „testing“ senden
        </x-button.dispatch>
    </div>
    <div class="col-md-6">
        {{-- Die Counter-Komponente des Packages lauscht mit #[On('testing')] --}}
        <div class="border rounded p-2 text-center">
            <livewire:counter />
        </div>
    </div>
</div>
