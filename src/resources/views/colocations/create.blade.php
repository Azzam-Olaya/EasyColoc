<x-dashboard-layout
    title="Créer une colocation"
    subtitle="Configurez votre nouveau espace partagé"
    activeNav="colocations"
    :activeColocation="null"
    backUrl="{{ route('colocations.index') }}"
>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl flex items-start gap-3">
            <span class="material-symbols-outlined mt-0.5 shrink-0">error</span>
            <ul class="text-sm font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="max-w-2xl">
        {{-- Form Card --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-6 py-5 border-b border-primary/5 flex items-center gap-4">
                <div class="h-12 w-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">holiday_village</span>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Nouvelle colocation</h3>
                    <p class="text-[11px] text-slate-400 mt-0.5">Donnez un nom à votre espace partagé pour commencer.</p>
                </div>
            </div>

            {{-- Form Body --}}
            <form method="POST" action="{{ route('colocations.store') }}" class="p-6 space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-widest">
                        Nom de la colocation
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm">apartment</span>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            autofocus
                            placeholder="Ex : L'Appart du Bonheur"
                            class="w-full pl-10 pr-4 py-3 bg-background-light dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-medium text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all"
                        />
                    </div>
                    @error('name')
                        <p class="text-xs text-red-500 font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[13px]">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 pt-2">
                    <button type="submit"
                            class="flex-1 py-3 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">add_home</span>
                        Créer la colocation
                    </button>
                    <a href="{{ route('colocations.index') }}"
                       class="px-5 py-3 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        Annuler
                    </a>
                </div>

            </form>
        </div>

        {{-- Info tip --}}
        <div class="mt-4 bg-primary/5 rounded-xl p-4 border border-primary/10 flex gap-3">
            <span class="material-symbols-outlined text-primary text-sm mt-0.5 shrink-0">lightbulb</span>
            <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
                Après la création, vous pourrez inviter vos colocataires et commencer à gérer vos dépenses ensemble.
            </p>
        </div>
    </div>

</x-dashboard-layout>