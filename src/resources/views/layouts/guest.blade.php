<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'EasyColoc') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL@24,400..700,0..1" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">
    <div class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark overflow-x-hidden">
        <header class="flex items-center bg-white/80 dark:bg-background-dark/80 backdrop-blur-md sticky top-0 z-50 p-4 justify-between border-b border-primary/10">
            <a href="{{ url('/') }}" class="text-primary flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary/10">
                <span class="material-symbols-outlined">house</span>
            </a>
            <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight tracking-tight flex-1 text-center pr-10">EasyColoc</h2>
        </header>
        <main class="flex-1 flex flex-col items-center justify-center px-4 py-8">
            {{ $slot }}
        </main>
        <footer class="p-6 text-center text-xs text-slate-400 uppercase tracking-widest">
            © {{ date('Y') }} EasyColoc. Tous droits réservés.
        </footer>
    </div>
</body>
</html>
