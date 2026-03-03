<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ config('app.name', 'EasyColoc') }} - Connexion</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

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
                    fontFamily: { "display": ["Plus Jakarta Sans"] },
                    borderRadius: { "DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px" }
                },
            },
        }
    </script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen flex items-center justify-center p-4">

<div class="relative flex h-auto w-full max-w-[480px] flex-col bg-white dark:bg-slate-900 rounded-xl shadow-xl overflow-hidden border border-primary/10">

    <!-- Header -->
    <header class="flex items-center bg-white/80 dark:bg-background-dark/80 backdrop-blur-md sticky top-0 z-50 p-4 justify-between border-b border-primary/10">
        <a href="{{ url('/') }}" class="text-primary flex size-10 shrink-0 items-center justify-center rounded-lg bg-primary/10">
            <span class="material-symbols-outlined">Back</span>
        </a>
        <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold leading-tight tracking-tight flex-1 text-center pr-10">EasyColoc</h2>
        <!-- <div class="flex items-center gap-2">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-primary transition-colors">Connexion</a>
                <a href="{{ route('register') }}" class="text-sm font-bold text-primary bg-primary/10 hover:bg-primary/20 px-4 py-2 rounded-xl transition-colors">S'inscrire</a>
            @endauth
        </div> -->
    </header>
    
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
                        Connecte-toi pour gérer ta colocation et les dépenses partagées.   
                </p>
            </div>

    <div class="px-6 py-4">

        <!-- Session Status & Errors -->
        @if (session('status'))
            <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

    

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-slate-900 dark:text-slate-100 text-sm font-semibold ml-1">Adresse email</label>
                <div class="relative">
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                           class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/20 bg-white dark:bg-slate-800 focus:border-primary h-14 pl-12 pr-4 placeholder:text-slate-400 text-base font-normal transition-all"
                           placeholder="exemple@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1"/>
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-slate-900 dark:text-slate-100 text-sm font-semibold ml-1">Mot de passe</label>
                <div class="relative">
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                           class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/20 bg-white dark:bg-slate-800 focus:border-primary h-14 pl-12 pr-12 placeholder:text-slate-400 text-base font-normal transition-all"
                           placeholder="••••••••">
                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer">visibility</span>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1"/>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between px-1 pt-2">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" class="rounded border-primary/30 text-primary focus:ring-primary/20 h-5 w-5 transition-colors cursor-pointer">
                    <span class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-primary transition-colors">Se souvenir de moi</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">Mot de passe oublié ?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[0.98]">
                    Se connecter
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <div class="mt-8 text-center">
            <p class="text-slate-600 dark:text-slate-400 text-sm">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-primary font-bold hover:underline ml-1">S'inscrire gratuitement</a>
            </p>
        </div>

    </div>
</div>

<script>
    document.querySelectorAll('.material-symbols-outlined.cursor-pointer').forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                this.textContent = 'visibility';
            }
        });
    });
</script>

</body>
</html>