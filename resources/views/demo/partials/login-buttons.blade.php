{{-- Ein-Klick-Logins für die drei Demo-Konten (POST, ohne Passwort im Frontend). --}}
<div class="d-flex flex-wrap gap-2">
    @foreach (\App\Enums\DemoRole::cases() as $role)
        <form method="POST" action="{{ route('demo.login', $role) }}">
            @csrf
            <button type="submit" class="btn btn-outline-{{ $role->variant() }}">
                <i class="bi bi-box-arrow-in-right"></i> {{ __('Als :role anmelden', ['role' => $role->label()]) }}
            </button>
        </form>
    @endforeach
</div>
