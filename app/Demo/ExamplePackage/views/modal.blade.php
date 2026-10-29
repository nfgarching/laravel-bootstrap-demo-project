{{-- example::modal – Beitrag zur ModalRegistry, wird einmal pro Seite gerendert --}}
<x-modal modid="exampleModal" title="{{ __('Modal aus dem Beispiel-Package') }}">
    <p>{{ __('Dieses Modal steht in keiner Seite. Das Beispiel-Package hat es über die ModalRegistry beigetragen; layout::parts.modals rendert es auf jeder Seite.') }}</p>
    <p class="mb-0 small text-body-secondary">{{ __('Wird das Package deaktiviert, verschwindet es zusammen mit Navbar-Eintrag und Sidebar-Abschnitt.') }}</p>
</x-modal>
