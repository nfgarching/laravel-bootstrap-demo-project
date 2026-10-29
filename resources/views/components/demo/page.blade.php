{{--
    Einheitlicher Rahmen der Demo-Unterseiten von core: Kopf mit Einleitung
    (Slot intro), Inhalt, am Ende der Link zur passenden Dokumentation.
--}}
@props(['page'])

@php
    $meta = \App\Demo\CorePages::find($page);
@endphp

<x-app-layout :title="__($meta['title'])">

    <x-slot:header>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-2">
                <li class="breadcrumb-item"><a href="{{ route('demo.home') }}">{{ __('Demo') }}</a></li>
                @if ($page !== 'index')
                    <li class="breadcrumb-item"><a href="{{ route('demo.core.index') }}">core</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ __($meta['title']) }}</li>
            </ol>
        </nav>
        <h1 class="h3 mb-2"><i class="bi bi-{{ $meta['icon'] }}"></i> {{ __($meta['title']) }}</h1>
        @isset($intro)
            <div class="text-body-secondary mb-4" style="max-width: 60rem;">{{ $intro }}</div>
        @endisset
    </x-slot:header>

    {{ $slot }}

    <hr class="mt-5">
    <p class="mb-5 pb-5">
        <a href="{{ \App\Demo\CorePages::docUrl($meta['doc']) }}" target="_blank" rel="noopener">
            <i class="bi bi-github"></i> {{ __('Dokumentation auf GitHub') }}
        </a>
        <span class="small text-body-secondary">({{ $meta['doc'] }})</span>
    </p>

</x-app-layout>
