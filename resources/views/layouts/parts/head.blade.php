{{-- Override von layout::parts.head: Bootstrap und Icons kommen per Vite statt CDN,
     das Favicon kennzeichnet die Umgebung (siehe App\Demo\Favicons). --}}
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' – ' : '' }}{{ config('app.name', 'Laravel') }}</title>

    <link href="{{ route('demo.favicon', \App\Demo\Favicons::forEnvironment(app()->environment())) }}" rel="icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

</head>
