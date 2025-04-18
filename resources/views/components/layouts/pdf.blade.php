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

    <style>
        body {
            position: relative;
            margin: 0;
            padding: 0;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .watermark-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: -1000;
            pointer-events: none;
        }

        .watermark-image {
            opacity: 0.15;
            /* Ajusta la transparencia según necesites */
            max-width: 70%;
            /* Ajusta el tamaño según necesites */
            max-height: 70%;
        }
    </style>

    <link type="text/css" rel="stylesheet" href="pdf.css">
    {{-- @vite('resources/css/filament/admin/theme.css') --}}

</head>

<body class="antialiased">

    <div class="watermark-container">
        <img class="watermark-image" src="{{ $watermarkImageBase64 }}" alt="Watermark">
    </div>

    <div class="content">
        <x-dynamic-component :component="$current" :datos="$datos" />
    </div>
</body>

</html>
