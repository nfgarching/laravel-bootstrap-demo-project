<x-demo.page page="props">

    <x-slot:intro>
        {{ __('Prop ist ein polymorphes Key-Value-Model mit Status und Typ. Jedes Model kann über eine morphMany-Beziehung beliebig viele Props tragen – in dieser Demo die Kontakte. Die CRUD-Oberfläche liefert das Package mit dem PropController selbst.') }}
    </x-slot:intro>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <x-card class="h-100">
                <x-slot:header>
                    <div class="card-header fw-semibold">{{ __('Am eigenen Model') }} <code>app/Models/Contact.php</code></div>
                </x-slot:header>
                <pre class="mb-3"><code class="language-php">use Illuminate\Database\Eloquent\Relations\MorphMany;
use Nfgarching\Core\Models\Prop;

public function props(): MorphMany
{
    return $this->morphMany(Prop::class, 'model');
}

// Verwendung
$contact->props()->create([
    'key' => 'iban_1', 'state' => 'verified', 'type' => 'iban',
    'label' => 'Privat', 'value' => 'DE00 0000 0000 0000 0000 00',
]);</code></pre>
                <p class="small text-body-secondary mb-0">
                    {{ __('Die Tabelle props legt die Anwendung an (database/migrations/…_create_props_table.php): id, model_type, model_id, key, state, type, label, value, data (JSON), memo.') }}
                </p>
            </x-card>
        </div>
        <div class="col-lg-5">
            <x-card class="h-100">
                <x-slot:header>
                    <div class="card-header fw-semibold">{{ __('Demo-Datenbestand') }}</div>
                </x-slot:header>
                <x-desc.group>
                    <x-desc :label="__('Props')" :value="$propCount" />
                    <x-desc :label="__('Kontakte mit Props')" :value="$contactCount" />
                </x-desc.group>
                <h3 class="h6">state</h3>
                <p>
                    @foreach ($states as $state => $total)
                        <span class="badge text-bg-light border">{{ $state }}: {{ $total }}</span>
                    @endforeach
                </p>
                <h3 class="h6">type</h3>
                <p class="mb-0">
                    @foreach ($types as $type => $total)
                        <span class="badge text-bg-light border">{{ $type }}: {{ $total }}</span>
                    @endforeach
                </p>
            </x-card>
        </div>
    </div>

    <h2 class="h5">{{ __('CRUD-Seiten des Packages') }}</h2>
    <p style="max-width: 60rem;">
        {{ __('Die Routen core.props.* liegen in der Rollengruppe admin. Mit spatie/laravel-permission hängt RouteRoles deshalb role:admin an – nur das Demo-Konto Admin kommt hinein, alle anderen erhalten 403.') }}
    </p>

    @guest
        @include('demo.partials.login-required', ['message' => __('Melde dich als Admin an, um die Prop-Verwaltung zu öffnen.')])
    @else
        @unless (auth()->user()->hasRole('admin'))
            <div class="alert alert-warning">
                {{ __('Angemeldet als :name – diese Rolle hat keinen Zugriff auf core.props.*. Zum Ausprobieren:', ['name' => auth()->user()->name]) }}
                <div class="mt-2">@include('demo.partials.login-buttons')</div>
            </div>
        @endunless
    @endguest

    <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="{{ route('core.props.index') }}" class="btn btn-primary"><i class="bi bi-list-ul"></i> {{ __('Liste') }} (/props)</a>
        <a href="{{ route('core.props.index', ['type' => 'iban']) }}" class="btn btn-outline-primary">{{ __('Gefiltert: type = iban') }}</a>
        <a href="{{ route('core.props.create') }}" class="btn btn-outline-primary"><i class="bi bi-plus-lg"></i> {{ __('Neu anlegen') }}</a>
    </div>

    <div class="alert alert-secondary small">
        <i class="bi bi-slash-circle"></i>
        {{ __('destroy() und action() sind im Package noch Stubs mit dd(). Die Demo fängt core.props.destroy, core.props.action und die Sammelaktion „Löschen“ per Middleware ab und meldet „In der Demo deaktiviert“. Die Sammelaktion „Ändern“ (store mit switchTo=change) funktioniert.') }}
    </div>

</x-demo.page>
