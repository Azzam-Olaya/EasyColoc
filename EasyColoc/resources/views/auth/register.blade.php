<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name', 'EasyColoc') }} - Inscription</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ee2b8c",
                        "background-light": "#f8f6f7",
                        "background-dark": "#221019",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans"]
                    },
                    borderRadius: { "DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px" }
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen flex items-center justify-center p-4">

<div class="relative flex h-auto w-full max-w-[480px] flex-col bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-primary/10">

    <!-- Header -->
    <div class="flex items-center bg-white dark:bg-slate-900 p-4 pb-2 justify-between">
        <a href="{{ route('login') }}" class="text-primary flex size-12 shrink-0 items-center justify-center hover:bg-primary/5 rounded-full transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-slate-900 dark:text-slate-100 text-lg font-bold leading-tight tracking-tight flex-1 text-center pr-12">EasyColoc</h2>
    </div>

    <div class="px-6 py-4">

        <!-- Session Error -->
        @if (session('error'))
            <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <!-- Hero Icon -->
        <div class="flex justify-center mb-4">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-4xl">favorite</span>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-slate-900 dark:text-slate-100 tracking-tight text-[32px] font-bold leading-tight text-center pb-2">
            Créer un compte
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-base font-normal leading-normal pb-6 text-center">
            Rejoins la communauté et gère ta colocation en toute simplicité.
        </p>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-slate-900 dark:text-slate-100 text-sm font-semibold ml-1">Nom complet</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">person</span>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/20 bg-white dark:bg-slate-800 focus:border-primary h-14 pl-12 pr-4 placeholder:text-slate-400 text-base font-normal transition-all"
                           placeholder="Jean Dupont">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1"/>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-slate-900 dark:text-slate-100 text-sm font-semibold ml-1">Adresse email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">mail</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                           class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/20 bg-white dark:bg-slate-800 focus:border-primary h-14 pl-12 pr-4 placeholder:text-slate-400 text-base font-normal transition-all"
                           placeholder="jean@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1"/>
            </div>

            
            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-slate-900 dark:text-slate-100 text-sm font-semibold ml-1">Mot de passe</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">lock</span>
                    <input id="password" name="password" type="password" required autocomplete="new-password"
                           class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/20 bg-white dark:bg-slate-800 focus:border-primary h-14 pl-12 pr-12 placeholder:text-slate-400 text-base font-normal transition-all"
                           placeholder="••••••••">
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer">visibility</span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1"/>
            </div>

            <div class="flex flex-col gap-1.5">
                <label for="password_confirmation" class="text-slate-900 dark:text-slate-100 text-sm font-semibold ml-1">Confirmer le mot de passe</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">lock_reset</span>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                           class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/20 bg-white dark:bg-slate-800 focus:border-primary h-14 pl-12 pr-4 placeholder:text-slate-400 text-base font-normal transition-all"
                           placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1"/>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[0.98]">
                    S'inscrire
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-slate-600 dark:text-slate-400 text-sm">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-primary font-bold hover:underline ml-1">Se connecter</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>