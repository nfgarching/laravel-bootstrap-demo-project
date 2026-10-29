<x-demo.page page="roles">

    <x-slot:intro>
        {{ __('Die Routen des Packages hängen RouteRoles::middleware(gruppe) an. Ist spatie/laravel-permission installiert und nutzt das User-Model HasRoles, wird daraus role:… mit den Rollen aus config(app.route_roles); sonst bleibt es bei auth. Die Tabelle unten ist zur Laufzeit aus dem Router ermittelt.') }}
    </x-slot:intro>

    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <x-card class="h-100">
                <x-slot:header>
                    <div class="card-header fw-semibold">{{ __('Demo-Konto') }}</div>
                </x-slot:header>
                @auth
                    <p>
                        {{ __('Angemeldet als') }} <strong>{{ auth()->user()->name }}</strong>
                        @foreach (auth()->user()->getRoleNames() as $roleName)
                            <span class="badge text-bg-secondary">{{ $roleName }}</span>
                        @endforeach
                    </p>
                    <p class="small mb-2">{{ __('Rolle wechseln:') }}</p>
                    @include('demo.partials.login-buttons')
                    <form method="POST" action="{{ route('logout') }}" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-box-arrow-right"></i> {{ __('Abmelden') }}
                        </button>
                    </form>
                @else
                    @include('demo.partials.login-required', ['message' => __('Nicht angemeldet. Ein Klick meldet dich mit einem der drei Demo-Konten an – ohne Passwort.')])
                @endauth
            </x-card>
        </div>
        <div class="col-lg-6">
            <x-card class="h-100">
                <x-slot:header>
                    <div class="card-header fw-semibold"><code>config('app.route_roles')</code> {{ __('dieser Demo') }}</div>
                </x-slot:header>
                <pre class="mb-2"><code class="language-php">'route_roles' => [
@foreach (config('app.route_roles') as $group => $roles)
    '{{ $group }}' => '{{ $roles }}',
@endforeach
],</code></pre>
                <p class="small text-body-secondary mb-0">
                    {{ __('Die role-Middleware kennt keine Rangfolge – admin steht deshalb in jeder Gruppe. Die Registrierung (/register) ist in der Demo durch eine App-Route ersetzt.') }}
                </p>
            </x-card>
        </div>
    </div>

    <h2 class="h5">{{ __('Routen des Packages') }}</h2>
    <p class="small text-body-secondary">
        {{ __('Grün: für das aktuelle Konto erreichbar · Rot: nicht erreichbar (Gast → Login, falsche Rolle → 403, angemeldet → Gast-Routen leiten weiter).') }}
    </p>
    <div class="table-responsive">
        <table class="table table-sm table-hover align-middle">
            <thead class="table-light">
                <tr class="text-uppercase small text-body-secondary">
                    <th>{{ __('Methode') }}</th>
                    <th>URI</th>
                    <th>Name</th>
                    <th>{{ __('Gruppe') }}</th>
                    <th>{{ __('Voraussetzung') }}</th>
                    <th class="text-center">{{ __('Zugriff') }}</th>
                    <th>{{ __('Demo') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($routes as $route)
                    <tr>
                        <td class="small font-monospace">{{ $route['methods'] }}</td>
                        <td class="font-monospace">{{ $route['uri'] }}</td>
                        <td class="small">{{ $route['name'] ?? '–' }}</td>
                        <td>{{ $route['group'] ?? '–' }}</td>
                        <td class="small">{{ $route['requirement'] }}</td>
                        <td class="text-center">
                            @if ($route['accessible'])
                                <span class="badge text-bg-success"><i class="bi bi-check-lg"></i> {{ __('ja') }}</span>
                            @else
                                <span class="badge text-bg-danger"><i class="bi bi-x-lg"></i> {{ __('nein') }}</span>
                            @endif
                        </td>
                        <td class="small text-body-secondary">
                            @if ($route['overridden'])
                                {{ __('durch App-Route ersetzt') }}
                            @elseif ($route['disabled'])
                                {{ __('deaktiviert') }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-demo.page>
