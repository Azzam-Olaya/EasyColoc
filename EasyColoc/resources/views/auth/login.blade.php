<x-guest-layout :title="'EasyColoc - Connexion'">
    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900/50 p-8 rounded-xl shadow-xl shadow-primary/5 border border-primary/5">

        {{-- Session messages --}}
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

        {{-- Hero image --}}
        <div class="@container mb-8">
            <div class="w-full bg-center bg-no-repeat bg-cover flex flex-col justify-end overflow-hidden rounded-xl min-h-[180px] shadow-inner"
                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuB5G2HKvvVpkwsDcPPtQ8CyfziWYGZa3gOD5X_LWO9TiT_PwqZ36HMaOwXwns1C676ZOr75hsL-Ap-b9ggQE0RZB51bH_51tBmlkaBqIhcj34aQq3LD91NvJI0U8XScsQKdb42P3yrKXhPu_iu4nsRyTA3Bs0RbNS2IuPvFRdZO5AP2a-cOz4x1TPVHTqMAo4xwmT6f0c_KSiZ0ueCwUBD-7yOjd8adhWnPsmYka8JeGbRSPoTz-_AbvjzTbRBirc-9-iUzWofdqcgM");'>
            </div>
        </div>

        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl font-bold leading-tight mb-2">Bon retour !</h1>
            <p class="text-slate-500 dark:text-slate-400 text-base font-normal">Connecte-toi pour gérer ta colocation et les dépenses partagées.</p>
        </div>

        {{-- Login form --}}
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div class="flex flex-col gap-2">
                <label for="email" class="text-slate-700 dark:text-slate-300 text-sm font-semibold px-1">Adresse email</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">mail</span>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/10 bg-background-light dark:bg-background-dark/50 focus:border-primary h-14 pl-12 pr-4 placeholder:text-slate-400 text-base font-normal"
                        placeholder="hello@example.com">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            <div class="flex flex-col gap-2">
                <label for="password" class="text-slate-700 dark:text-slate-300 text-sm font-semibold px-1">Mot de passe</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">lock</span>
                    <input id="password" name="password" type="password" required autocomplete="current-password"
                        class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/10 bg-background-light dark:bg-background-dark/50 focus:border-primary h-14 pl-12 pr-4 placeholder:text-slate-400 text-base font-normal"
                        placeholder="••••••••">
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div class="flex items-center justify-between px-1">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" class="rounded border-primary/30 text-primary focus:ring-primary/20 h-5 w-5 transition-colors cursor-pointer">
                    <span class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-primary transition-colors">Se souvenir de moi</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary hover:text-primary/80 transition-colors">Mot de passe oublié ?</a>
                @endif
            </div>

            <button type="submit" class="w-full h-14 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all active:scale-[0.98] mt-4">
                Se connecter
            </button>
        </form>

        {{-- Divider --}}
        <div class="relative my-10">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-primary/10"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white dark:bg-slate-900 text-slate-400">Ou continuer avec</span>
            </div>
        </div>

        
        <div class="mt-10 text-center">
            <p class="text-slate-500 dark:text-slate-400">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-primary font-bold hover:underline ml-1">S'inscrire gratuitement</a>
            </p>
        </div>

    </div>
</x-guest-layout>