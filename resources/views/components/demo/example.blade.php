{{--
    Demo-Karte: rendert ein Beispiel-Partial und zeigt daneben dessen Quelltext,
    gelesen aus derselben Datei – Vorschau und Code können nicht auseinanderlaufen.

    title        Überschrift der Karte
    view         View-Name des Partials (z. B. demo.core.examples.buttons.index)
    description  optionaler Hinweistext
    data         Variablen für das Partial (@include-Daten)
    livewire     true  = Partial in der Livewire-Wurzel demo.playground rendern
                 'name' = diese Livewire-Komponente rendern (sie nutzt das Partial als View)
--}}
@props([
    'title',
    'view',
    'description' => null,
    'data' => [],
    'livewire' => false,
])

@php
    $id = 'ex-'.Str::slug(str_replace('.', '-', Str::after($view, 'demo.core.examples.')));
    $path = view()->getFinder()->find($view);
    $source = file_get_contents($path);
@endphp

<div {{ $attributes->merge(['class' => 'card demo-example mb-4']) }} id="{{ $id }}">

    <div class="card-header d-flex flex-wrap align-items-center gap-2">
        <h3 class="h6 mb-0 me-auto">{{ $title }}</h3>
        <ul class="nav nav-pills card-header-pills small" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active py-1 px-2" id="{{ $id }}-preview-tab" data-bs-toggle="tab"
                    data-bs-target="#{{ $id }}-preview" type="button" role="tab" aria-controls="{{ $id }}-preview"
                    aria-selected="true">
                    <i class="bi bi-eye"></i> {{ __('Vorschau') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link py-1 px-2" id="{{ $id }}-code-tab" data-bs-toggle="tab"
                    data-bs-target="#{{ $id }}-code" type="button" role="tab" aria-controls="{{ $id }}-code"
                    aria-selected="false">
                    <i class="bi bi-code-slash"></i> {{ __('Blade-Code') }}
                </button>
            </li>
        </ul>
    </div>

    @if ($description)
        <div class="card-body border-bottom small text-body-secondary py-2">{{ $description }}</div>
    @endif

    <div class="tab-content">

        <div class="tab-pane fade show active" id="{{ $id }}-preview" role="tabpanel" aria-labelledby="{{ $id }}-preview-tab">
            <div class="card-body">
                @if ($livewire === true)
                    <livewire:demo.playground :view="$view" :key="$id" />
                @elseif (is_string($livewire))
                    @livewire($livewire, [], key($id))
                @else
                    @include($view, $data)
                @endif
            </div>
        </div>

        <div class="tab-pane fade" id="{{ $id }}-code" role="tabpanel" aria-labelledby="{{ $id }}-code-tab">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-3 py-2 border-bottom small">
                <code class="text-body-secondary">{{ Str::after($path, base_path().DIRECTORY_SEPARATOR) }}</code>
                <x-button.clipboard :text="$source" type="outline-secondary" :tooltip="__('Code kopieren')"
                    :message="__('Code in die Zwischenablage kopiert')">
                    <i class="bi bi-clipboard"></i> {{ __('Kopieren') }}
                </x-button.clipboard>
            </div>
            <pre><code class="language-xml">{{ $source }}</code></pre>
        </div>

    </div>

</div>
