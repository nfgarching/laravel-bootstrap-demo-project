<x-demo.page page="registries">

    <x-slot:intro>
        {{ __('core kennt die anderen Packages nicht. Stattdessen bindet es drei Registries als Singleton – SidebarNavigation, NavbarNavigation und ModalRegistry –, und jedes Feature-Package trägt im boot() seines ServiceProviders eine View mit order und optionalem when-Guard bei. Die Shell rendert nur noch die sortierte, sichtbare Liste.') }}
    </x-slot:intro>

    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
        <form method="POST" action="{{ route('demo.core.registries.toggle') }}">
            @csrf
            <button type="submit" @class(['btn', 'btn-outline-danger' => $active, 'btn-success' => ! $active])>
                <i class="bi bi-{{ $active ? 'toggle-on' : 'toggle-off' }}"></i>
                {{ $active ? __('Demo-Package deaktivieren') : __('Demo-Package aktivieren') }}
            </button>
        </form>
        <span class="small text-body-secondary">
            {{ __('Gespeichert in der Session; ausgewertet über die when-Guards. Status:') }}
            <span @class(['badge', 'text-bg-success' => $active, 'text-bg-secondary' => ! $active])>{{ $active ? __('aktiv') : __('inaktiv') }}</span>
        </span>
        @if ($active)
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                {{ __('Beigetragenes Modal öffnen') }}
            </button>
        @endif
    </div>

    <div class="row g-4">
        <div class="col-xl-7">
            <x-card>
                <x-slot:header>
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span class="fw-semibold">app/Demo/ExamplePackage/ExampleServiceProvider.php</span>
                        <x-button.clipboard :text="$providerSource" type="outline-secondary" :tooltip="__('Code kopieren')">
                            <i class="bi bi-clipboard"></i>
                        </x-button.clipboard>
                    </div>
                </x-slot:header>
                <pre class="mb-0"><code class="language-php">{{ $providerSource }}</code></pre>
            </x-card>
        </div>

        <div class="col-xl-5">
            <x-card>
                <x-slot:header>
                    <div class="card-header fw-semibold">{{ __('Ergebnis: sichtbare Einträge dieser Anfrage') }}</div>
                </x-slot:header>

                @foreach ([
                    'NavbarNavigation::visibleItems()' => $navbarItems,
                    'SidebarNavigation::visibleSections()' => $sidebarSections,
                    'ModalRegistry::visibleModals()' => $modals,
                ] as $label => $views)
                    <h3 class="h6 mt-2"><code>{{ $label }}</code></h3>
                    <ol class="small">
                        @forelse ($views as $view)
                            <li>
                                <code>{{ $view }}</code>
                                @if (str_starts_with($view, 'example::'))
                                    <span class="badge text-bg-primary">{{ __('Beispiel-Package') }}</span>
                                @endif
                            </li>
                        @empty
                            <li class="text-body-secondary">{{ __('keine') }}</li>
                        @endforelse
                    </ol>
                @endforeach

                <x-slot:footer>
                    <span class="small text-body-secondary">
                        {{ __('Im Layout erscheinen sie als Button „Beispiel-Package“ in der Navbar, als Abschnitt in der Sidebar und als Modal #exampleModal.') }}
                    </span>
                </x-slot:footer>
            </x-card>
        </div>
    </div>

    <h2 class="h5 mt-5">{{ __('Weitere Dokumentation') }}</h2>
    <ul>
        <li><a href="{{ \App\Demo\CorePages::docUrl('docs/navbar-navigation.md') }}" target="_blank" rel="noopener">docs/navbar-navigation.md</a></li>
        <li><a href="{{ \App\Demo\CorePages::docUrl('docs/modal-registry.md') }}" target="_blank" rel="noopener">docs/modal-registry.md</a></li>
    </ul>

</x-demo.page>
