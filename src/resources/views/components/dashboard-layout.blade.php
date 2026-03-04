<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'EasyColoc' }} — EasyColoc</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    fontFamily: { "display": ["Plus Jakarta Sans", "sans-serif"] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        [x-cloak] { display: none !important; }
    </style>
    {{ $head ?? '' }}
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="w-72 bg-white dark:bg-slate-900 border-r border-primary/10 flex flex-col shrink-0">
        <div class="p-8 flex flex-col gap-8 h-full">

            {{-- Logo --}}
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 bg-primary rounded-xl flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">home_work</span>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-none">EasyColoc</h1>
                    <p class="text-xs font-medium text-primary/60 uppercase tracking-widest mt-1">Management</p>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="flex flex-col gap-2 flex-1">
                @php $active = $activeNav ?? 'dashboard'; @endphp

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-semibold transition-all
                          {{ $active === 'dashboard' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-slate-600 dark:text-slate-400 hover:bg-primary/5 hover:text-primary' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>

                @if (isset($activeColocation) && $activeColocation)
                <a href="{{ route('colocations.show', $activeColocation) }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                          {{ $active === 'expenses' ? 'bg-primary text-white shadow-lg shadow-primary/20 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-primary/5 hover:text-primary' }}">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span>Expenses</span>
                </a>
                @endif
                
                @if (auth()->user()?->is_global_admin)
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                          {{ $active === 'users' ? 'bg-primary text-white shadow-lg shadow-primary/20 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-primary/5 hover:text-primary' }}">
                    <span class="material-symbols-outlined">group</span>
                    <span>Members</span>
                </a>
                @elseif (isset($activeColocation) && $activeColocation)
                <a href="{{ route('colocations.show', $activeColocation) }}#members"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                          {{ $active === 'members' ? 'bg-primary text-white shadow-lg shadow-primary/20 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-primary/5 hover:text-primary' }}">
                    <span class="material-symbols-outlined">group</span>
                    <span>Members</span>
                </a>
                @endif

                <a href="{{ route('colocations.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                          {{ $active === 'colocations' ? 'bg-primary text-white shadow-lg shadow-primary/20 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-primary/5 hover:text-primary' }}">
                    <span class="material-symbols-outlined">apartment</span>
                    <span>Colocations</span>
                </a>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                          {{ $active === 'settings' ? 'bg-primary text-white shadow-lg shadow-primary/20 font-semibold' : 'text-slate-600 dark:text-slate-400 hover:bg-primary/5 hover:text-primary' }}">
                    <span class="material-symbols-outlined">settings</span>
                    <span>Settings</span>
                </a>
            </nav>

            {{-- Upgrade CTA --}}
            <div class="bg-primary/5 rounded-xl p-4 mt-auto">
                <div class="flex items-center gap-2 mb-3">
                    <div class="p-2 bg-primary/10 rounded-lg text-primary">
                        <span class="material-symbols-outlined text-sm">auto_awesome</span>
                    </div>
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Upgrade to Pro</span>
                </div>
                <p class="text-[11px] text-slate-500 leading-relaxed mb-3">Get advanced statistics and unlimited members.</p>
                <button class="w-full py-2 bg-white dark:bg-slate-800 text-primary border border-primary/20 rounded-lg text-xs font-bold hover:bg-primary hover:text-white transition-all">
                    Upgrade Now
                </button>
            </div>

        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <main class="flex-1 flex flex-col overflow-y-auto bg-background-light dark:bg-background-dark">

        {{-- Top Header --}}
        <header class="h-20 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-primary/10 px-8 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center gap-3">
                @if (isset($backUrl))
                <a href="{{ $backUrl }}"
                   class="h-9 w-9 rounded-xl bg-primary/5 hover:bg-primary/10 text-primary flex items-center justify-center transition-colors mr-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                </a>
                @endif
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">{{ $title ?? 'Dashboard' }}</h2>
                    @if (isset($subtitle))
                    <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-6">
                {{-- Search (optional) --}}
                @if (isset($showSearch) && $showSearch)
                <div class="relative w-80">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                    <input class="w-full pl-10 pr-4 py-2.5 bg-background-light dark:bg-slate-800 border-none rounded-xl focus:ring-2 focus:ring-primary/20 text-sm"
                           placeholder="Search..." type="text"/>
                </div>
                @endif

                {{-- Notifications --}}
                <button class="relative p-2 text-slate-500 hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full border-2 border-white dark:border-slate-900"></span>
                </button>

                {{-- User Menu --}}
                <div class="flex items-center gap-3 pl-6 border-l border-primary/10" x-data="{ open: false }">
                    <div class="text-right">
                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-slate-500 font-medium">Roommate Gold</p>
                    </div>
                    <div class="relative">
                        <button @click="open = !open"
                                class="h-10 w-10 rounded-full bg-primary/10 border-2 border-primary/20 overflow-hidden flex items-center justify-center focus:outline-none">
                            @if (auth()->user()->profile_photo_url ?? false)
                                <img alt="Profile" class="h-full w-full object-cover" src="{{ auth()->user()->profile_photo_url }}"/>
                            @else
                                <span class="text-primary font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                            @endif
                        </button>
                        <div x-show="open" @click.outside="open = false" x-cloak
                             class="absolute right-0 top-full mt-2 w-48 rounded-xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-xl py-2 z-50">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary/5 hover:text-primary transition-colors">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary/5 hover:text-primary transition-colors">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="p-8 max-w-7xl mx-auto w-full space-y-8">
            {{ $slot }}
        </div>

        {{-- Footer --}}
        <footer class="p-8 text-center text-[11px] text-slate-400 font-medium border-t border-primary/5 mt-auto">
            © {{ date('Y') }} EasyColoc. Designed with love for shared living.
        </footer>

    </main>
</div>

</body>
</html>
