{{-- Link zum übergeordneten Model. Die Route wird aus getShowRouteName()
     oder aus dem Klassennamen (props.show, contacts.show, …) abgeleitet;
     gibt es sie nicht, bleibt der Button deaktiviert. --}}
<div class="d-flex flex-wrap gap-2 align-items-center">
    <x-button.model :model="$prop->model_type" :modid="$prop->model_id" />
    <span class="small text-body-secondary">
        {{ $prop->model_type }} #{{ $prop->model_id }} – keine Route contacts.show, daher deaktiviert
    </span>
</div>
