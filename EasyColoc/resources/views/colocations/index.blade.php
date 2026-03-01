<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-900 dark:text-slate-100 leading-tight">
            {{ __('Mes colocations') }}
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

        <div class="bg-white dark:bg-slate-900/50 p-6 rounded-xl shadow-xl shadow-primary/5 border border-primary/5">
            @if ($activeColocation)
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="size-12 rounded-full bg-primary/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-2xl">home_work</span>
                        </div>
                        <div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">Colocation active</div>
                            <div class="text-lg font-bold text-slate-900 dark:text-slate-100">{{ $activeColocation->name }}</div>
                            <div class="text-xs text-primary font-medium">Owner : {{ $activeColocation->owner?->name }}</div>
                        </div>
                    </div>
                    <a href="{{ route('colocations.show', $activeColocation) }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all">
                        <span class="material-symbols-outlined">open_in_new</span>
                        Ouvrir
                    </a>
                </div>
            @else
                <div class="text-gray-700 dark:text-slate-300 mb-4">
                    Tu n'as pas encore de colocation active.
                </div>
                <form method="POST" action="{{ route('colocations.store') }}" class="space-y-4">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="name" class="text-slate-700 dark:text-slate-300 text-sm font-semibold px-1">Nom de la colocation</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">home_work</span>
                            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                                class="flex w-full rounded-xl text-slate-900 dark:text-slate-100 focus:outline-0 focus:ring-2 focus:ring-primary/20 border border-primary/10 bg-background-light dark:bg-background-dark/50 h-14 pl-12 pr-4"
                                placeholder="Appart Rue de la Paix">
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>
                    <button type="submit" class="w-full h-14 bg-primary text-white font-bold rounded-xl shadow-lg shadow-primary/25 hover:bg-primary/90 transition-all active:scale-[0.98]">
                        Créer ma colocation
                    </button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
