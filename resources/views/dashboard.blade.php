{{-- Ersetzt page::dashboard (Route dashboard prüft resources/views/dashboard.blade.php).
     Das Original zeigt Hostname und Datenbank-Verbindung und verlinkt auf Routen
     anderer Packages, die es in der Demo nicht gibt. --}}
<x-app-layout :title="__('Dashboard')">
    <x-slot:header>
        <h1 class="h3 mb-3"><i class="bi bi-speedometer2"></i> {{ __('Dashboard') }}</h1>
    </x-slot:header>

    <x-card style="max-width: 48rem;">
        <x-slot:header>
            <div class="card-header fw-semibold">{{ __('Route dashboard – Rollengruppe partner') }}</div>
        </x-slot:header>
        <p>{{ __('Willkommen, :name. Diese Seite erreichen nur die Rollen admin und partner.', ['name' => auth()->user()?->name]) }}</p>
        <p class="small text-body-secondary mb-0">{{ __('In der Demo ersetzt eine App-View das Dashboard des Packages, weil dieses Server-Informationen anzeigt.') }}</p>
        <x-slot:footer>
            <a href="{{ route('demo.core.roles') }}">{{ __('Zurück zur Rollen-Übersicht') }}</a>
        </x-slot:footer>
    </x-card>
</x-app-layout>
