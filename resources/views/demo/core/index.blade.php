<x-demo.page page="index">

    <x-slot:intro>
        {{ __('nfgarching/core ist das Basis-Package für Laravel-Anwendungen mit Bootstrap 5 und Livewire 4. Es bringt wiederverwendbare Blade-Komponenten, die App-Shell, Registries für Navigation und Modals, ein polymorphes Prop-Model mit CRUD sowie Traits für Listen, Formulare und Suche mit.') }}
    </x-slot:intro>

    <div class="alert alert-info" role="note">
        <i class="bi bi-info-circle"></i>
        {{ __('Es gibt noch keine getaggten Releases – das Package wird auf dev-main entwickelt, die API kann sich ändern.') }}
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <x-card class="h-100">
                <x-slot:header>
                    <div class="card-header fw-semibold">{{ __('Anforderungen') }}</div>
                </x-slot:header>
                <ul class="mb-0">
                    <li>PHP 8.4</li>
                    <li>Laravel 13</li>
                    <li>Livewire 4</li>
                    <li>{{ __('Bootstrap 5.3 und Bootstrap Icons (lädt die Anwendung, hier per Vite)') }}</li>
                    <li>{{ __('kyslik/column-sortable (wird mitinstalliert)') }}</li>
                    <li>{{ __('optional: spatie/laravel-permission für die Rollenprüfung') }}</li>
                </ul>
                <x-slot:footer>
                    <a href="{{ \App\Demo\CorePages::REPOSITORY }}" target="_blank" rel="noopener">
                        <i class="bi bi-github"></i> {{ __('Repository auf GitHub') }}
                    </a>
                </x-slot:footer>
            </x-card>
        </div>

        <div class="col-lg-8">
            <x-card class="h-100">
                <x-slot:header>
                    <div class="card-header fw-semibold">{{ __('Installation') }}</div>
                </x-slot:header>

                <p class="small mb-1"><strong>{{ __('Aus GitHub (VCS-Repository)') }}</strong> – {{ __('in der composer.json der Anwendung:') }}</p>
                <pre><code class="language-json">"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/nfgarching/laravel-bootstrap-core"
    }
]</code></pre>
                <pre><code class="language-bash">composer require nfgarching/core:dev-main</code></pre>

                <p class="small mb-1 mt-3"><strong>{{ __('Lokal als Path-Repository (Entwicklung, so in dieser Demo)') }}</strong></p>
                <pre><code class="language-bash">git clone https://github.com/nfgarching/laravel-bootstrap-core.git packages/nfgarching/core</code></pre>
                <pre><code class="language-json">"repositories": [
    {
        "type": "path",
        "url": "packages/nfgarching/core",
        "options": { "symlink": true }
    }
]</code></pre>
                <pre><code class="language-bash">composer require nfgarching/core:@dev</code></pre>

                <p class="small text-body-secondary mb-0">
                    {{ __('Der LibraryServiceProvider wird per Package-Discovery registriert. Migrationen bringt das Package nicht mit – die Tabellen users und props legt die Anwendung an.') }}
                </p>
            </x-card>
        </div>
    </div>

    <h2 class="h5 mb-3">{{ __('Bereiche der Demo') }}</h2>
    <div class="row g-3">
        @foreach (collect(\App\Demo\CorePages::all())->except('index') as $page)
            <div class="col-sm-6 col-xl-4">
                <a href="{{ route($page['route']) }}" class="card h-100 text-decoration-none demo-tile">
                    <div class="card-body">
                        <h3 class="h6 text-body"><i class="bi bi-{{ $page['icon'] }} text-primary"></i> {{ __($page['title']) }}</h3>
                        <p class="card-text small text-body-secondary mb-0">{{ __($page['summary']) }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</x-demo.page>
