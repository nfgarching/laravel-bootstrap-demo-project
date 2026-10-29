<div class="d-flex flex-wrap gap-3 align-items-center mb-3">
    <x-icon name="star" size="sm" />
    <x-icon name="star-half" />
    <x-icon name="star-fill" size="lg" class="text-warning" />
    <x-icon name="emoji-smile" size="xl" class="text-success" />
    <x-icon />
</div>

{{-- counter: Laufzeit seit startTime (z. B. microtime(true) im Controller) --}}
<x-counter :startTime="microtime(true) - 0.0421" />
