{{-- Ersetzt page::admin (Route admin prüft resources/views/admin.blade.php).
     Das Original listet config('database.connections') inklusive Zugangsdaten. --}}
<x-app-layout :title="__('Admin')">
    <x-slot:header>
        <h1 class="h3 mb-3"><i class="bi bi-shield-lock"></i> {{ __('Admin') }}</h1>
    </x-slot:header>

    <x-card style="max-width: 48rem;">
        <x-slot:header>
            <div class="card-header fw-semibold">{{ __('Route admin – Rollengruppe admin') }}</div>
        </x-slot:header>
        <p>{{ __('Willkommen, :name. Diese Seite erreicht nur die Rolle admin.', ['name' => auth()->user()?->name]) }}</p>
        <p class="small text-body-secondary mb-0">{{ __('In der Demo ersetzt eine App-View die Admin-Seite des Packages, weil diese die Datenbank-Konfiguration samt Zugangsdaten ausgibt.') }}</p>
        <x-slot:footer>
            <a href="{{ route('core.props.index') }}">{{ __('Zur Prop-Verwaltung') }}</a>
        </x-slot:footer>
    </x-card>
</x-app-layout>
