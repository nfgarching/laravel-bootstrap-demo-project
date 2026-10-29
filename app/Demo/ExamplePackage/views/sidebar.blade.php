{{-- example::sidebar – Beitrag zur SidebarNavigation-Registry --}}
<li class="nav-item mt-3">
    <h6 class="sidebar-heading px-3 mb-1 text-body-secondary text-uppercase small">{{ __('Beispiel-Package') }}</h6>
</li>
<li class="nav-item">
    <a class="nav-link py-1 small" href="{{ route('demo.core.registries') }}">
        <i class="bi bi-puzzle"></i> {{ __('Eintrag aus der Registry') }}
    </a>
</li>
