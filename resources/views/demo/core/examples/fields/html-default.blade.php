{{-- field.html.default: klassische Formularfelder mit name, old() und @error --}}
<x-form action="#" method="GET" onsubmit="event.preventDefault()">
    <div class="row g-3">
        <div class="col-md-6">
            <x-field field="name" label="Name" value="Erika Mustermann" />
        </div>
        <div class="col-md-6">
            <x-field field="email" label="E-Mail" type="email" value="erika.mustermann@example.com" />
        </div>
        <div class="col-md-6">
            <label class="form-label">field.select</label>
            <x-field.select field="city" label="Ort" value="Testdorf" :options="[
                'Musterstadt' => 'Musterstadt',
                'Beispielhausen' => 'Beispielhausen',
                'Testdorf' => 'Testdorf',
            ]" />
        </div>
        <div class="col-md-6">
            <label class="form-label">field.text</label>
            <x-field.text field="memo" rows="3" value="Mehrzeiliger Text" />
        </div>
    </div>
</x-form>
