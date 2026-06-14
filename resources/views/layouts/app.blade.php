<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BonImplant — Made in Armenia')</title>
    <meta name="description" content="@yield('meta_description', 'BonImplant — Innovative bone implant solutions made in Armenia. High-quality orthopedic, traumatology and surgical instruments.')">

    <!-- Fonts: Montserrat Armenian (self-hosted via app.css @font-face) -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Prevent Alpine.js flicker --}}
    <style>[x-cloak] { display: none !important; }</style>

    @stack('head')
</head>
<body>
    {{-- HEADER --}}
    @include('components.header')

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('components.footer')

    {{-- Alpine.js --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>

    @stack('scripts')
</body>
</html>
