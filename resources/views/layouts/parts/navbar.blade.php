{{-- Override von layout::parts.navbar: ohne Platzhalter-Suche und Platzhalter-Links
     des Packages. Sidebar-Toggler, Brand, NavbarNavigation-Registry und
     Offcanvas-Toggler sind unverändert. --}}
<nav class="navbar navbar-expand-lg bg-body-secondary sticky-top">

    <div class="container-fluid">

        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="{{ __('Navigation umschalten') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <button class="btn btn-link nav-link px-2" type="button" @click="sidebarOpen = !sidebarOpen"
            aria-label="{{ __('Sidebar umschalten') }}" data-demo-hint="sidebar-toggle">
            <i class="bi fs-6" :class="sidebarOpen ? 'bi-layout-sidebar' : 'bi-layout-sidebar-inset'"></i>
        </button>

        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{ route('demo.home') }}">
            {{ config('app.name') }}
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                @foreach (app(\Nfgarching\Core\Navigation\NavbarNavigation::class)->visibleItems() as $item)
                    @includeIf($item)
                @endforeach
            </ul>
        </div>

        <ul class="navbar-nav flex-row ms-auto ms-lg-2">
            <li class="nav-item">
                <a class="nav-link" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarDark"
                    aria-label="{{ __('Offcanvas öffnen') }}">
                    <span class="bi bi-three-dots-vertical"></span>
                </a>
            </li>
        </ul>

    </div>

</nav>

@if (file_exists(resource_path('views/layouts/parts/offcanvas.blade.php')))
    @include('layouts.parts.offcanvas')
@else
    @include('layout::parts.offcanvas')
@endif
