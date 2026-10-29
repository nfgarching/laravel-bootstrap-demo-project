{{-- Sidebar-Bereich der Demo (registriert in App\Providers\DemoServiceProvider):
     alle Packages, darunter die Unterseiten des aktiven Packages core. --}}
<li class="nav-item">
    <h6 class="sidebar-heading px-3 mt-2 mb-1 text-body-secondary text-uppercase small">{{ __('Packages') }}</h6>
</li>

<li class="nav-item">
    <a @class(['nav-link d-flex align-items-center gap-2', 'active fw-semibold' => request()->routeIs('demo.core.*')])
        href="{{ route('demo.core.index') }}">
        <i class="bi bi-box-seam"></i> core
        <span class="badge text-bg-success ms-auto">{{ __('aktiv') }}</span>
    </a>
    <ul class="nav flex-column ms-3 border-start">
        @foreach (\App\Demo\CorePages::all() as $page)
            <li class="nav-item">
                <a @class(['nav-link py-1 small', 'active fw-semibold' => request()->routeIs($page['route'])])
                    href="{{ route($page['route']) }}"
                    @if (request()->routeIs($page['route'])) aria-current="page" @endif>
                    <i class="bi bi-{{ $page['icon'] }}"></i> {{ __($page['title']) }}
                </a>
            </li>
        @endforeach
    </ul>
</li>

@foreach (\App\Demo\DemoPackages::upcoming() as $package)
    <li class="nav-item">
        <span class="nav-link d-flex align-items-center gap-2 text-body-secondary" aria-disabled="true">
            <i class="bi bi-{{ $package['icon'] }}"></i> {{ $package['name'] }}
            <span class="badge text-bg-light border ms-auto">{{ __('demnächst') }}</span>
        </span>
    </li>
@endforeach
