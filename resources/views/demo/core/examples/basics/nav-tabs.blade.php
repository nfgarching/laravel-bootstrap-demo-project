@php
    $tabs = ['Übersicht', 'Details', '<i class="bi bi-gear"></i> Einstellungen'];
    $token = 'demo-tabs';
    $show = 0;
@endphp

<x-nav.tabs :$tabs :$token :$show>
    <x-nav.item tab="0" :$token :$show>
        <p class="pt-3 mb-0">Inhalt von Tab 1 – die Tab-Titel dürfen HTML enthalten.</p>
    </x-nav.item>
    <x-nav.item tab="1" :$token :$show>
        <p class="pt-3 mb-0">Inhalt von Tab 2.</p>
    </x-nav.item>
    <x-nav.item tab="2" :$token :$show>
        <p class="pt-3 mb-0">Inhalt von Tab 3.</p>
    </x-nav.item>
</x-nav.tabs>
