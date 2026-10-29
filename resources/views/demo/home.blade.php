<x-app-layout :title="__('Start')">

    <x-slot:header>
        <h1 class="h3 mb-2">{{ __('Laravel-Packages von nfgarching') }}</h1>
        <p class="text-body-secondary mb-4" style="max-width: 60rem;">
            {{ __('Diese Demo führt die Funktionen der Laravel-Packages vor. Jede Seite rendert sich selbst im Layout des Basis-Packages core – Navbar, Sidebar, Offcanvas und Toasts sind also echte Package-Bausteine.') }}
        </p>
    </x-slot:header>

    <div class="row g-4">

        <div class="col-md-6 col-xl-3">
            <a href="{{ route('demo.core.index') }}" class="card h-100 text-decoration-none demo-tile border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-box-seam fs-3 text-success me-2"></i>
                        <h2 class="h5 mb-0 text-body">core</h2>
                        <span class="badge text-bg-success ms-auto">{{ __('aktiv') }}</span>
                    </div>
                    <p class="card-text text-body-secondary small mb-0">
                        {{ __('Bootstrap-5- und Livewire-4-Basis: Komponenten, App-Shell, Registries, Prop-Model und Rollen.') }}
                    </p>
                </div>
                <div class="card-footer small text-success">{{ __('Demo öffnen') }} <i class="bi bi-arrow-right"></i></div>
            </a>
        </div>

        @foreach ($upcoming as $package)
            <div class="col-md-6 col-xl-3">
                <div class="card h-100 bg-body-tertiary" aria-disabled="true">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-{{ $package['icon'] }} fs-3 text-body-secondary me-2"></i>
                            <h2 class="h5 mb-0 text-body-secondary">{{ $package['name'] }}</h2>
                            <span class="badge text-bg-light border ms-auto">{{ __('demnächst') }}</span>
                        </div>
                        <p class="card-text text-body-secondary small mb-0">{{ __($package['summary']) }}</p>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</x-app-layout>
