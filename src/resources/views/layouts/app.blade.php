<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'EasyColoc') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { min-height: max(884px, 100dvh); }
        .material-symbols-outlined.filled { font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">

<div class="min-h-screen max-w-screen mx-auto bg-white shadow-xl flex flex-col">
    @php
        $navTitleStr = 'Dashboard';
        if (isset($navTitle) && $navTitle !== null && $navTitle !== '') {
            $navTitleStr = trim(strip_tags((string) $navTitle));
        } elseif (isset($header) && $header !== null) {
            $navTitleStr = trim(strip_tags((string) $header));
        }
        if ($navTitleStr === '') {
            $navTitleStr = 'Dashboard';
        }
    @endphp
    @include('layouts.navigation', ['navTitle' => $navTitleStr])
    <main class="w-screen flex-1 overflow-y-auto pb-20">
        {{ $slot }}
    </main>
    @include('layouts.bottom-nav')
</div>

</body>
</html>
