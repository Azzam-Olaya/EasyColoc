<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'EasyColoc') }} - Forgot Password</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
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
    <div class="flex items-center bg-white dark:bg-slate-900 p-4 pb-2 justify-between">
        <a href="{{ route('login') }}" class="text-primary flex size-12 shrink-0 items-center justify-center hover:bg-primary/5 rounded-full transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-slate-900 dark:text-slate-100 text-lg font-bold leading-tight tracking-tight flex-1 text-center pr-12">EasyColoc</h2>
    </div>

    <div class="px-6 py-4">

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl flex items-center gap-2">
                <span class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1">check_circle</span>
                <span class="text-sm">{{ session('status') }}</span>
            </div>
        @endif

        <!-- Hero Icon -->
        <div class="flex justify-center mb-4">
            <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings: 'FILL' 1">lock_reset</span>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-slate-900 dark:text-slate-100 tracking-tight text-[32px] font-bold leading-tight text-center pb-2">
            Forgot Password?
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-base font-normal leading-normal pb-6 text-center">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </p>

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-slate-900 dark:text-slate-100 text-sm font-semibold ml-1">Email address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                        <span class="material-symbols-outlined text-xl">mail</span>
                    </div>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                           class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/20 bg-white dark:bg-slate-800 focus:border-primary h-14 pl-12 pr-4 placeholder:text-slate-400 text-base font-normal transition-all @error('email') border-red-500 focus:border-red-500 @enderror"
                           placeholder="yourname@email.com">
                </div>
                @error('email')
                    <div class="flex items-center gap-2 mt-1 text-red-500 text-sm">
                        <span class="material-symbols-outlined text-base">error</span>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[0.98]">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="mt-8 text-center">
            <p class="text-slate-600 dark:text-slate-400 text-sm">
                Remember your password?
                <a href="{{ route('login') }}" class="text-primary font-bold hover:underline ml-1">Back to login</a>
            </p>
        </div>

        <!-- Note -->
        <div class="mt-4 mb-2 text-center">
            <p class="text-slate-400 dark:text-slate-500 text-sm">
                {{ __("Didn't receive the email? Check your spam folder or wait a few minutes.") }}
            </p>
        </div>

    </div>
</div>

</body>
</html>