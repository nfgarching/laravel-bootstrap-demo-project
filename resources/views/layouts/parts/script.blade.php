{{-- Override von layout::parts.script: identisch zum Package, nur ohne das
     Bootstrap-CDN-Bundle (kommt per Vite, window.bootstrap) und mit Demo-Banner. --}}
@include('demo.partials.banner')

@if (file_exists(resource_path('views/layouts/parts/modals.blade.php')))
    @include('layouts.parts.modals')
@else
    @include('layout::parts.modals')
@endif
@if (file_exists(resource_path('views/layouts/parts/toasts.blade.php')))
    @include('layouts.parts.toasts')
@else
    @include('layout::parts.toasts')
@endif

@livewireScripts

@stack('scripts')

<script>
    window.openPopup = function (url, opts) {
        if (!opts) { return window.open(url, '_blank'); }
        const p = Object.fromEntries(opts.split(',').map(e => e.split('=')));
        const w = parseInt(p.width) || 800;
        const h = parseInt(p.height) || 800;
        const left = Math.round((screen.width - w) / 2);
        const top = Math.round((screen.height - h) / 2);
        window.open(url, '_blank', `${opts},left=${left},top=${top}`);
    };
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    });
</script>

<script>
    window.addEventListener('reload-window', event => {
        window.location.reload(false);
    })
</script>
