<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyColoc') }} – Gère ta colocation en douceur</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Tailwind config -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ee2b8c",
                        "background-light": "#f8f6f7",
                        "background-dark": "#221019",
                        "soft-lavender": "#f3e8ff",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                    borderRadius: { "DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px" },
                },
            },
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen flex flex-col">

<div class="relative flex h-auto min-h-screen w-full flex-col bg-background-light dark:bg-background-dark group/design-root overflow-x-hidden">

    <!-- Header -->
    <header class="flex items-center bg-white/80 dark:bg-background-dark/80 backdrop-blur-md sticky top-0 z-50 p-4 justify-between border-b border-primary/10">
        <a href="{{ url('/') }}" class="text-primary flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary/10">
            <span class="material-symbols-outlined">house</span>
        </a>
        <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight tracking-tight flex-1 text-center pr-10">EasyColoc</h2>
        <div class="flex items-center gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Connexion</a>
                <a href="{{ route('register') }}" class="text-sm font-bold text-primary bg-primary/10 hover:bg-primary/20 px-4 py-2 rounded-xl transition-colors">S'inscrire</a>
            @endauth
        </div>
    </header>

    <!-- Main -->
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-8">
        <div class="w-full max-w-[480px] bg-white dark:bg-slate-900/50 p-8 rounded-xl shadow-xl shadow-primary/5 border border-primary/5">

            <!-- Illustration / Hero -->
            <div class="@container mb-8">
                <div class="w-full bg-center bg-no-repeat bg-cover flex flex-col justify-end overflow-hidden rounded-xl min-h-[180px] shadow-inner" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB5G2HKvvVpkwsDcPPtQ8CyfziWYGZa3gOD5X_LWO9TiT_PwqZ36HMaOwXwns1C676ZOr75hsL-Ap-b9ggQE0RZB51bH_51tBmlkaBqIhcj34aQq3LD91NvJI0U8XScsQKdb42P3yrKXhPu_iu4nsRyTA3Bs0RbNS2IuPvFRdZO5AP2a-cOz4x1TPVHTqMAo4xwmT6f0c_KSiZ0ueCwUBD-7yOjd8adhWnPsmYka8JeGbRSPoTz-_AbvjzTbRBirc-9-iUzWofdqcgM");'></div>
            </div>

            <!-- Welcome Text -->
            <div class="text-center mb-8">
                <h1 class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl font-bold leading-tight mb-2">
                    Bienvenue sur EasyColoc
                </h1>
                <p class="text-slate-500 dark:text-slate-400 text-base font-normal">
                    Gère ta colocation en douceur : dépenses partagées, qui doit à qui, invitations… tout en un seul endroit.
                </p>
            </div>

            <!-- Actions -->
            @guest
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('login') }}" class="flex-1 h-14 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">login</span>
                    Se connecter
                </a>
                <a href="{{ route('register') }}" class="flex-1 h-14 border-2 border-primary/30 text-primary font-bold rounded-xl hover:bg-primary/5 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">person_add</span>
                    Créer un compte
                </a>
            </div>
            @else
            <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center gap-2 w-full h-14 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all mt-4">
                <span class="material-symbols-outlined">dashboard</span>
                Aller au tableau de bord
            </a>
            @endguest

            <!-- Features Grid -->
            <div class="grid grid-cols-3 gap-4 pt-8 text-center">
                <div class="bg-white dark:bg-slate-900/50 p-4 rounded-xl border border-primary/10">
                    <span class="material-symbols-outlined text-primary text-2xl mb-2">receipt_long</span>
                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">Dépenses</p>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Partagées</p>
                </div>
                <div class="bg-white dark:bg-slate-900/50 p-4 rounded-xl border border-primary/10">
                    <span class="material-symbols-outlined text-primary text-2xl mb-2">splitscreen</span>
                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">Qui doit</p>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400">à qui</p>
                </div>
                <div class="bg-white dark:bg-slate-900/50 p-4 rounded-xl border border-primary/10">
                    <span class="material-symbols-outlined text-primary text-2xl mb-2">groups</span>
                    <p class="text-xs font-semibold text-slate-700 dark:text-slate-300">Coloc</p>
                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Facile</p>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="p-6 text-center text-xs text-slate-400 uppercase tracking-widest">
        © {{ date('Y') }} EasyColoc. Tous droits réservés.
    </footer>

</div>
</body>
</html>