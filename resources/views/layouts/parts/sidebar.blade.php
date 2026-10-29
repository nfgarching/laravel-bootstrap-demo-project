{{-- Override von layout::parts.sidebar: nur die Bereiche aus der
     SidebarNavigation-Registry. Die fest verdrahteten Entwickler-, Docker- und
     Testseiten-Menüs des Packages verlinken auf Routen, die es hier nicht gibt. --}}
<ul class="nav flex-column mb-2">
    @foreach (app(\Nfgarching\Core\Navigation\SidebarNavigation::class)->visibleSections() as $section)
        @includeIf($section)
    @endforeach
</ul>

<hr>

<div class="small text-body-secondary px-3 pb-3">
    <i class="bi bi-c-circle"></i> {{ date('Y') }} · {{ __('Demo-Anwendung') }}
</div>
