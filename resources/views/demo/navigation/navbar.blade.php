{{-- Navbar-Beitrag der Demo (registriert in App\Providers\DemoServiceProvider). --}}
<li class="nav-item">
    <a class="nav-link" href="{{ \App\Demo\CorePages::REPOSITORY }}" target="_blank" rel="noopener">
        <i class="bi bi-github"></i> GitHub
    </a>
</li>
<li class="nav-item">
    @auth
        <a class="nav-link" href="{{ route('demo.core.roles') }}">
            <i class="bi bi-person-check"></i> {{ auth()->user()->name }}
        </a>
    @else
        <a class="nav-link" href="{{ route('demo.core.roles') }}">
            <i class="bi bi-box-arrow-in-right"></i> {{ __('Demo-Login') }}
        </a>
    @endauth
</li>
