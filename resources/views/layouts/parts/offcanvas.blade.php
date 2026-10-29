{{-- Override von layout::parts.offcanvas: Demo-Konto statt Login-Formular und
     ohne Hostname/Datenbank-Angaben, die auf einer öffentlichen Seite nichts verloren haben. --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarDark" aria-labelledby="offcanvasNavbarDarkLabel">

    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarDarkLabel">{{ __('Seitenleiste') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="{{ __('Schließen') }}"></button>
    </div>

    <div class="offcanvas-body">

        <p class="small text-body-secondary">
            {{ __('Das Offcanvas-Panel ist Teil der App-Shell von nfgarching/core. Die Demo zeigt hier das aktuelle Konto.') }}
        </p>

        <h6 class="text-uppercase small text-body-secondary">{{ __('Demo-Konto') }}</h6>

        @auth
            <p class="mb-2">
                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                @foreach (auth()->user()->getRoleNames() as $roleName)
                    <span class="badge text-bg-secondary">{{ $roleName }}</span>
                @endforeach
            </p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> {{ __('Abmelden') }}
                </button>
            </form>
        @else
            @include('demo.partials.login-buttons')
        @endauth

        <hr>

        <p class="small text-body-secondary mb-0">
            ENV: {{ config('app.env') }} · {{ __('Package-Version') }} {{ config('app.version') }}
        </p>

    </div>
</div>
