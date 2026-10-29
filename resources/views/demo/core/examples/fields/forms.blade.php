{{-- form.*: Floating-Label-Felder für klassische Formulare; x-form ergänzt @csrf und Method-Spoofing --}}
<x-form action="#" method="PUT" onsubmit="event.preventDefault()">
    <div class="row g-3">
        <div class="col-md-6">
            <x-form.input field="name" label="Name" value="Max Mustermann" />
        </div>
        <div class="col-md-6">
            <x-form.select field="city" label="Ort" value="Beispielhausen" :options="[
                'Musterstadt' => 'Musterstadt',
                'Beispielhausen' => 'Beispielhausen',
                'Testdorf' => 'Testdorf',
            ]" />
        </div>
        <div class="col-12">
            <x-form.textarea field="memo" label="Notiz" value="Text im Floating-Label-Textfeld" />
        </div>
        <div class="col-12">
            <x-form.group>
                <span class="input-group-text"><i class="bi bi-at"></i></span>
                <input type="email" class="form-control" placeholder="form.group = input-group">
            </x-form.group>
        </div>
        <div class="col-12 d-flex gap-2">
            <x-form.label label="form.label:" class="col-form-label" />
            <x-form.cancel />
            <x-form.submit>Speichern</x-form.submit>
        </div>
    </div>
</x-form>
