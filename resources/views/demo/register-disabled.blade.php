<x-app-layout :title="__('Registrierung')">

    <x-slot:header>
        <h1 class="h3 mb-3"><i class="bi bi-person-x"></i> {{ __('Registrierung deaktiviert') }}</h1>
    </x-slot:header>

    <div class="alert alert-warning" style="max-width: 48rem;">
        <p>{{ __('Das Package stellt unter /register ein Registrierungsformular bereit. In der öffentlichen Demo ist die Route durch eine App-Route überschrieben – es gibt nur die drei Demo-Konten.') }}</p>
        <a href="{{ route('demo.core.roles') }}" class="btn btn-warning">
            <i class="bi bi-box-arrow-in-right"></i> {{ __('Zu den Demo-Logins') }}
        </a>
    </div>

</x-app-layout>
