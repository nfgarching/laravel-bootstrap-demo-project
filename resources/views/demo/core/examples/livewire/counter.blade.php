<div class="row g-3 align-items-center">
    <div class="col-md-6 text-center border rounded py-2">
        <livewire:counter />
    </div>
    <div class="col-md-6">
        {{-- Counter::increment() hört zusätzlich auf das Event „testing“ --}}
        <x-button.dispatch modalName="testing" type="outline-primary" :href="route('demo.core.livewire')">
            <i class="bi bi-broadcast"></i> Event „testing“ an alle Counter
        </x-button.dispatch>
    </div>
</div>
