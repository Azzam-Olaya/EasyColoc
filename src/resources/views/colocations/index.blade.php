<x-dashboard-layout
    title="Mes Colocations"
    subtitle="Gérez vos espaces partagés"
    activeNav="colocations"
    :activeColocation="$activeColocation ?? null"
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

    @if ($activeColocation)

        {{-- Active Colocation Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Colocation active</h3>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-50 text-green-600 text-[11px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Active
                </span>
            </div>

            <div class="flex items-center gap-5 mb-6">
                <div class="h-16 w-16 rounded-xl bg-primary/10 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-primary text-3xl">home_work</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">Current Home</p>
                    <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $activeColocation->name }}</h2>
                    <p class="text-sm text-slate-500 mt-1">Owner : <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $activeColocation->owner?->name }}</span></p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('colocations.show', $activeColocation) }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                    <span class="material-symbols-outlined text-sm">open_in_new</span>
                    Ouvrir la colocation
                </a>
                <a href="{{ route('colocations.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-sm">add_home</span>
                    Nouvelle
                </a>
            </div>
        </div>

    @else

        {{-- No Colocation Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 bg-white dark:bg-slate-900 rounded-xl border-2 border-dashed border-primary/20 text-center">
            <div class="w-24 h-24 bg-primary/5 rounded-full flex items-center justify-center text-primary mb-6">
                <span class="material-symbols-outlined text-5xl">holiday_village</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2">Pas encore de colocation !</h2>
            <p class="text-slate-500 max-w-sm mb-8 leading-relaxed">
                Tu n'as pas encore de colocation active. Crée ton propre espace ou rejoins une colocation existante.
            </p>
            <form method="POST" action="{{ route('colocations.store') }}" class="w-full max-w-sm space-y-4">
                @csrf
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">home_work</span>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full pl-12 pr-4 py-3 bg-background-light dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all"
                        placeholder="Nom de la colocation">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                <button type="submit"
                    class="w-full py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 hover:scale-[1.02] transition-transform active:scale-[0.98] flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">add_home</span>
                    Créer ma colocation
                </button>
            </form>
        </div>

    @endif

</x-dashboard-layout>
