{{-- Hinweis für Gäste auf Seiten, deren Inhalt einen Demo-Login braucht. --}}
<div class="alert alert-info">
    <p class="mb-2"><i class="bi bi-person-lock"></i> {{ $message }}</p>
    @include('demo.partials.login-buttons')
</div>
