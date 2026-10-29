<x-demo.page page="layout">

    <x-slot:intro>
        {{ __('Die App-Shell von core besteht aus dem Grundlayout layout::main mit Navbar, einklappbarer Sidebar, Offcanvas-Panel und Toasts. Diese Seite ist selbst in dieser Shell gerendert – die nummerierten Bereiche unten sind die echten Bausteine rund um diesen Text.') }}
    </x-slot:intro>

    @php
        $hints = [
            1 => ['Navbar', 'layout::parts.navbar – Brand, Einträge aus der NavbarNavigation-Registry; klappt unter 992 px in den Hamburger ein.'],
            2 => ['Sidebar-Toggler', 'Schaltet die Alpine-Variable sidebarOpen am body-Element um; die Sidebar wird ein- und ausgeblendet, main füllt dann die volle Breite.'],
            3 => ['Sidebar', 'layout::parts.sidebar – rendert nur die Bereiche der SidebarNavigation-Registry (hier: Packages und Beispiel-Package).'],
            4 => ['Offcanvas', 'layout::parts.offcanvas – Panel am rechten Rand, Toggler bleibt außerhalb der Navbar-Collapse immer sichtbar.'],
            5 => ['Toasts', 'layout::parts.toasts – reagieren auf die Browser-Events show-toast und show-message (z. B. aus Livewire per dispatch).'],
            6 => ['Hauptbereich', 'Das main-Element mit den Slots header, slot und footer von x-app-layout.'],
        ];
    @endphp

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="border rounded p-2 bg-body-tertiary small" aria-hidden="true">
                <div class="d-flex align-items-center gap-2 bg-body-secondary rounded px-2 py-2 mb-2">
                    <span class="demo-hint text-bg-primary">2</span>
                    <span class="me-auto">{{ config('app.name') }} <span class="demo-hint text-bg-primary ms-1">1</span></span>
                    <span class="demo-hint text-bg-primary">4</span>
                </div>
                <div class="d-flex gap-2" style="min-height: 9rem;">
                    <div class="bg-light border rounded p-2" style="width: 30%;">
                        <span class="demo-hint text-bg-primary">3</span>
                    </div>
                    <div class="border rounded p-2 flex-grow-1 position-relative bg-body">
                        <span class="demo-hint text-bg-primary">6</span>
                        <span class="demo-hint text-bg-primary position-absolute bottom-0 end-0 m-2">5</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <ol class="list-unstyled mb-0">
                @foreach ($hints as $number => [$label, $text])
                    <li class="d-flex gap-2 mb-2">
                        <span class="demo-hint text-bg-primary flex-shrink-0">{{ $number }}</span>
                        <span><strong>{{ __($label) }}</strong> – {{ __($text) }}</span>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>

    <x-demo.example :title="__('Toasts und Offcanvas auslösen')" view="demo.core.examples.layout.toasts"
        :description="__('Die Toasts hören auf die Browser-Events show-toast und show-message – aus Livewire genügt ein dispatch() mit message.')" />

    <h2 class="h5 mt-5">{{ __('Override-Pattern') }}</h2>
    <p style="max-width: 60rem;">
        {{ __('Jeder Teil der Shell wird per @@include eingebunden. Vorher prüft das Layout, ob die Anwendung eine eigene Variante unter resources/views/layouts/… mitbringt. So lässt sich jeder Teil überschreiben, ohne das Package zu forken.') }}
    </p>
    <div class="row g-4">
        <div class="col-xl-5">
            <p class="small text-body-secondary mb-1">{{ __('Im Package, layouts/main.blade.php:') }}</p>
            <pre><code class="language-xml">@@if (file_exists(resource_path('views/layouts/parts/navbar.blade.php')))
    @@include('layouts.parts.navbar')
@@else
    @@include('layout::parts.navbar')
@@endif</code></pre>
            <p class="small mb-1">{{ __('Diese Demo überschreibt so:') }}</p>
            <ul class="small">
                <li><code>layouts/parts/head.blade.php</code> – {{ __('Bootstrap per Vite statt CDN, Favicon je Umgebung') }}</li>
                <li><code>layouts/parts/script.blade.php</code> – {{ __('ohne Bootstrap-CDN, mit Demo-Banner') }}</li>
                <li><code>layouts/parts/navbar.blade.php</code> – {{ __('ohne Platzhalter-Suche und -Links') }}</li>
                <li><code>layouts/parts/sidebar.blade.php</code> – {{ __('nur Registry-Bereiche') }}</li>
                <li><code>layouts/parts/offcanvas.blade.php</code> – {{ __('Demo-Konto statt Server-Informationen') }}</li>
            </ul>
        </div>
        <div class="col-xl-7">
            <p class="small text-body-secondary mb-1">{{ __('In der App, resources/views/layouts/parts/navbar.blade.php:') }}</p>
            <pre><code class="language-xml">{{ file_get_contents(resource_path('views/layouts/parts/navbar.blade.php')) }}</code></pre>
        </div>
    </div>

    <h2 class="h5 mt-5">{{ __('Favicons') }}</h2>
    <p style="max-width: 60rem;">
        {{ __('Das Package liefert mehrere Favicon-Varianten mit. Ein eigenes Icon je Umgebung zeigt schon im Browser-Tab, ob man in Produktion, Staging oder lokal arbeitet. Diese Demo wählt die Variante anhand von APP_ENV (aktuell: :env).', ['env' => app()->environment()]) }}
    </p>
    <div class="row g-3">
        @foreach ($favicons as $variant => $purpose)
            <div class="col-6 col-md-4 col-xl-2">
                <div @class(['card h-100 text-center', 'border-primary' => $variant === \App\Demo\Favicons::forEnvironment(app()->environment())])>
                    <div class="card-body">
                        <img src="{{ route('demo.favicon', $variant) }}" width="32" height="32" alt="{{ $variant }}">
                        <div class="small fw-semibold mt-2"><code>{{ $variant === 'default' ? 'favicon.ico' : "favicon{$variant}.ico" }}</code></div>
                        <div class="small text-body-secondary">{{ __($purpose) }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-demo.page>
