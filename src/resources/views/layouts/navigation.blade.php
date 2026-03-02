<nav x-data="{ open: false }" class="sticky top-0 z-50 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-primary/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="size-10 rounded-full bg-primary/20 flex items-center justify-center overflow-hidden border-2 border-primary/30 text-primary">
                        <span class="material-symbols-outlined">home</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold leading-tight">EasyColoc</h1>
                        <p class="text-xs text-primary font-medium">{{ Auth::user()->name }}</p>
                    </div>
                </a>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard') }}" class="p-2 rounded-full hover:bg-primary/10 transition-colors {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-slate-600 dark:text-slate-400' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                </a>
                <a href="{{ route('colocations.index') }}" class="p-2 rounded-full hover:bg-primary/10 transition-colors {{ request()->routeIs('colocations.*') ? 'text-primary' : 'text-slate-600 dark:text-slate-400' }}">
                    <span class="material-symbols-outlined">groups</span>
                </a>
                @if (Auth::user()?->is_global_admin)
                    <a href="{{ route('admin.dashboard') }}" class="p-2 rounded-full hover:bg-primary/10 transition-colors {{ request()->routeIs('admin.*') ? 'text-primary' : 'text-slate-600 dark:text-slate-400' }}">
                        <span class="material-symbols-outlined">analytics</span>
                    </a>
                @endif
                <div class="relative" x-data="{ dropdown: false }">
                    <button @click="dropdown = ! dropdown" class="p-2 rounded-full hover:bg-primary/10 transition-colors text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined">settings</span>
                    </button>
                    <div x-show="dropdown" @click.outside="dropdown = false" x-cloak
                        class="absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-slate-900 border border-primary/10 shadow-lg py-2 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary/5">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-primary/5">
                                Déconnexion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-md text-slate-500 hover:bg-primary/10">
                    <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>
    </div>
    <div x-show="open" x-cloak class="sm:hidden border-t border-primary/10 bg-white dark:bg-slate-900/95 p-4 space-y-2">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 py-2 {{ request()->routeIs('dashboard') ? 'text-primary font-semibold' : 'text-slate-600' }}">Dashboard</a>
        <a href="{{ route('colocations.index') }}" class="flex items-center gap-2 py-2 {{ request()->routeIs('colocations.*') ? 'text-primary font-semibold' : 'text-slate-600' }}">Colocation</a>
        @if (Auth::user()?->is_global_admin)
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 py-2 {{ request()->routeIs('admin.*') ? 'text-primary font-semibold' : 'text-slate-600' }}">Statistiques</a>
        @endif
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 py-2 text-slate-600">Profil</a>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="flex items-center gap-2 py-2 text-slate-600 w-full text-left">Déconnexion</button>
        </form>
    </div>
</nav>
