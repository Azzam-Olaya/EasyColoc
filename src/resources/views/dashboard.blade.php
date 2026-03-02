<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto px-4 py-6 space-y-6 sm:max-w-2xl">
        @if (session('status'))
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl">
                {{ session('status') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        @if ($activeColocation)
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white dark:bg-slate-900/50 p-5 rounded-xl border border-primary/10 shadow-sm flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Ma colocation</span>
                        <span class="material-symbols-outlined text-primary text-xl">account_balance_wallet</span>
                    </div>
                    <p class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ $activeColocation->name }}</p>
                    <p class="text-xs text-primary font-medium">Owner : {{ $activeColocation->owner?->name }}</p>
                </div>
                <div class="bg-white dark:bg-slate-900/50 p-5 rounded-xl border border-primary/10 shadow-sm flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Réputation</span>
                        <span class="material-symbols-outlined text-primary text-xl">verified_user</span>
                    </div>
                    <p class="text-2xl font-bold text-slate-900 dark:text-slate-100">{{ auth()->user()->reputation_score ?? 0 }}<span class="text-sm font-normal text-slate-400">/100</span></p>
                    <p class="text-xs text-primary font-medium">Score</p>
                </div>
            </div>

            <a href="{{ route('colocations.show', $activeColocation) }}" class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 flex items-center justify-center gap-2 transition-transform active:scale-95">
                <span class="material-symbols-outlined">add_circle</span>
                Voir ma colocation & dépenses
            </a>

            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">Accès rapide</h2>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('colocations.show', $activeColocation) }}" class="flex flex-col items-start gap-3 rounded-xl border border-primary/10 bg-white dark:bg-primary/5 p-4 text-left hover:bg-primary/5 transition-colors group">
                        <div class="bg-primary/10 text-primary p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <div>
                            <h3 class="text-slate-900 dark:text-slate-100 text-sm font-bold">Dépenses</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs">Voir et ajouter</p>
                        </div>
                    </a>
                    <a href="{{ route('colocations.show', $activeColocation) }}#balances" class="flex flex-col items-start gap-3 rounded-xl border border-primary/10 bg-white dark:bg-primary/5 p-4 text-left hover:bg-primary/5 transition-colors group">
                        <div class="bg-primary/10 text-primary p-2 rounded-lg group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">splitscreen</span>
                        </div>
                        <div>
                            <h3 class="text-slate-900 dark:text-slate-100 text-sm font-bold">Qui doit à qui</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs">Soldes & remboursements</p>
                        </div>
                    </a>
                </div>
            </section>
        @else
            <div class="bg-white dark:bg-slate-900/50 p-8 rounded-xl border border-primary/10 shadow-sm text-center space-y-4">
                <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto">
                    <span class="material-symbols-outlined text-primary text-4xl">home_work</span>
                </div>
                <p class="text-slate-600 dark:text-slate-400">Tu n'as pas encore de colocation active.</p>
                <a href="{{ route('colocations.index') }}" class="inline-flex items-center justify-center gap-2 w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-xl shadow-lg shadow-primary/20 transition-all">
                    <span class="material-symbols-outlined">add_circle</span>
                    Créer ou rejoindre une colocation
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
