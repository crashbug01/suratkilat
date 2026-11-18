@props([
    'title' => 'SuratKilat',
    'description' => null,
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="suratkilat">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @if ($description)
        <meta name="description" content="{{ $description }}">
    @endif
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{ $head ?? '' }}
</head>
<body class="flex min-h-screen flex-col bg-base-100 text-base-content antialiased">
    <a href="#konten" class="sr-only z-50 rounded bg-base-100 px-4 py-2 focus:not-sr-only focus:absolute focus:left-2 focus:top-2">
        Lewati ke konten
    </a>

    <x-site-header />

    <main id="konten" class="flex-1">
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>
