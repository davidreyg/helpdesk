<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">

    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $filename }}</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <link type="text/css" rel="stylesheet" href="pdf.css">
    @vite('resources/css/filament/admin/theme.css')

</head>

<body class="antialiased">
    <x-dynamic-component :component="$current" :datos="$datos" />
</body>

</html>
