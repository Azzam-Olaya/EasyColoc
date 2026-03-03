<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reset Password - EasyColoc</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CSS via CDN (si vous l'utilisez, sinon gardez @vite) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&display=swap" rel="stylesheet">
    
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
                    borderRadius: {"DEFAULT": "0.5rem", "lg": "1rem", "xl": "1.5rem", "full": "9999px"},
                },
            },
        }
    </script>
    
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 antialiased">
    <div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
        <!-- Top Navigation -->
        <nav class="flex items-center bg-transparent p-4 justify-between">
            <a href="{{ route('login') }}" class="text-slate-900 dark:text-slate-100 flex size-12 shrink-0 items-center justify-center rounded-full hover:bg-primary/10 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-white text-xl">home</span>
                </div>
                <h2 class="text-slate-900 dark:text-slate-100 text-lg font-bold leading-tight tracking-tight">EasyColoc</h2>
            </div>
            <div class="size-12"></div>
        </nav>

        <!-- Header Content -->
        <div class="px-6 pt-10 pb-6 text-center max-w-lg mx-auto">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-primary/10 mb-6">
                <span class="material-symbols-outlined text-primary text-4xl">lock_reset</span>
            </div>
            <h1 class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl font-bold leading-tight mb-3">Reset Password</h1>
            <p class="text-slate-600 dark:text-slate-400 text-base font-normal leading-relaxed">
                Secure your account by creating a new password. Enter your email and choose a strong one.
            </p>
        </div>

        <!-- Form Section -->
        <div class="flex-1 px-6 max-w-lg mx-auto w-full">
            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Field -->
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-slate-700 dark:text-slate-300 text-sm font-semibold ml-1">Email address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">mail</span>
                        </div>
                        <input id="email" 
                               type="email" 
                               name="email" 
                               value="{{ old('email', $request->email) }}" 
                               required 
                               autofocus 
                               autocomplete="username"
                               class="form-input block w-full pl-11 pr-4 h-14 rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400 @error('email') border-red-500 @enderror" 
                               placeholder="yourname@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password Field -->
                <div class="flex flex-col gap-2">
                    <label for="password" class="text-slate-700 dark:text-slate-300 text-sm font-semibold ml-1">New Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">lock</span>
                        </div>
                        <input id="password" 
                               type="password" 
                               name="password" 
                               required 
                               autocomplete="new-password"
                               class="form-input block w-full pl-11 pr-12 h-14 rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400 @error('password') border-red-500 @enderror" 
                               placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl" id="password-icon">visibility</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="flex flex-col gap-2">
                    <label for="password_confirmation" class="text-slate-700 dark:text-slate-300 text-sm font-semibold ml-1">Confirm Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl">verified_user</span>
                        </div>
                        <input id="password_confirmation" 
                               type="password" 
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               class="form-input block w-full pl-11 pr-12 h-14 rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/50 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-slate-400" 
                               placeholder="••••••••">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-xl" id="password_confirmation-icon">visibility</span>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reset Button -->
                <div class="pt-6">
                    <button type="submit" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-xl shadow-lg shadow-primary/25 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <span>Reset Password</span>
                    </button>
                </div>
            </form>

            <!-- Support Link -->
            <div class="mt-8 text-center">
                <p class="text-slate-500 dark:text-slate-500 text-sm">
                    Didn't receive the link? 
                    <a href="{{ route('password.request') }}" class="text-primary font-semibold hover:underline decoration-2 underline-offset-4">Resend Email</a>
                </p>
            </div>
        </div>

        <!-- Decorative Background Element -->
        <div class="fixed bottom-0 left-0 right-0 h-1 w-full bg-gradient-to-r from-primary/20 via-primary to-primary/20 opacity-30"></div>
    </div>

    <!-- JavaScript pour toggle password visibility -->
    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '-icon');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                field.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>