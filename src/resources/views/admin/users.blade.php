<x-dashboard-layout
    title="Tous les Membres"
    subtitle="Gérez tous les utilisateurs de la plateforme"
    activeNav="users"
>

    @if (session('status'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">check_circle</span>
            <span class="text-sm font-medium">{{ session('status') }}</span>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Tous les utilisateurs</h3>
                <p class="text-xs text-slate-500 mt-1">Gérez les accès et les bannissements communautaires</p>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-primary/10 text-primary text-[11px] font-bold">
                <span class="material-symbols-outlined text-[14px]">group</span>
                {{ $users->total() }} membres
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($users as $u)
                <div class="bg-background-light dark:bg-slate-800/50 p-4 rounded-xl border border-slate-100 dark:border-slate-800 flex items-center justify-between {{ $u->is_banned ? 'opacity-70' : '' }}">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-white dark:bg-slate-900 flex items-center justify-center font-bold {{ $u->is_banned ? 'text-slate-400' : 'text-primary' }} shadow-sm">
                            @if ($u->profile_photo_url)
                                <img src="{{ $u->profile_photo_url }}" class="h-full w-full object-cover rounded-full {{ $u->is_banned ? 'grayscale' : '' }}">
                            @else
                                {{ strtoupper(substr($u->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-slate-900 dark:text-slate-100">{{ $u->name }}</span>
                                @if ($u->is_global_admin)
                                    <span class="px-1.5 py-0.5 rounded-md bg-amber-50 text-amber-600 text-[9px] font-bold uppercase tracking-wider">Admin</span>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-500 font-medium">{{ $u->email }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-2">
                        @if ($u->is_banned)
                            <span class="px-2 py-0.5 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-[10px] font-bold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Banni
                            </span>
                            <form method="POST" action="{{ route('admin.users.unban', $u) }}">
                                @csrf
                                <button class="text-[10px] font-bold text-primary hover:text-primary/80 transition-colors">Débannir</button>
                            </form>
                        @else
                            <span class="px-2 py-0.5 rounded-full bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 text-[10px] font-bold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Actif
                            </span>
                            <form method="POST" action="{{ route('admin.users.ban', $u) }}">
                                @csrf
                                <button class="text-[10px] font-bold text-slate-400 hover:text-red-500 transition-colors" onclick="return confirm('Bannir cet utilisateur ?')">Bannir</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>

</x-dashboard-layout>