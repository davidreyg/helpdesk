<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    {{-- {!! $fontHtml !!}
    <style>
        .default-template-container * {
            font-size: 0.7rem;
            /* margin-top: 1rem; */
            font-family: '{{ $fontFam }}', sans-serif;
        }
    </style> --}}

    <link type="text/css" rel="stylesheet" href="pdf.css">
    @vite('resources/css/filament/admin/theme.css')

</head>

<body class="antialiased">
    <div>
        testing
    </div>
</body>

</html>
