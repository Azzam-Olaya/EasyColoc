<x-dashboard-layout
    title="Rejoindre une colocation"
    subtitle="Vous avez reçu une invitation"
    activeNav="colocations"
    :activeColocation="null"
>

    @if (session('error'))
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined">error</span>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    <div class="max-w-xl">
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-6 py-5 border-b border-primary/5 flex items-center gap-4">
                <div class="h-12 w-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-primary uppercase tracking-widest mb-0.5">Invitation</p>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Rejoindre une colocation</h3>
                </div>
            </div>

            {{-- Card Body --}}
            <div class="p-6 space-y-6">

                {{-- Colocation Info --}}
                <div class="flex items-center gap-4 bg-background-light dark:bg-slate-800/50 rounded-xl p-4">
                    <div class="h-12 w-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">groups</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-0.5">Colocation</p>
                        <p class="text-lg font-extrabold text-slate-900 dark:text-white">
                            {{ $invitation->colocation?->name }}
                        </p>
                    </div>
                </div>

                {{-- Meta --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Email invité</p>
                        <p class="font-mono text-sm text-slate-800 dark:text-slate-100">{{ $invitation->email }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Statut</p>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold
                            @if ($invitation->status === 'pending') bg-amber-50 text-amber-600
                            @elseif($invitation->status === 'accepted') bg-green-50 text-green-600
                            @else bg-slate-100 text-slate-500 @endif">
                            <span class="w-1.5 h-1.5 rounded-full
                                @if ($invitation->status === 'pending') bg-amber-500
                                @elseif($invitation->status === 'accepted') bg-green-500
                                @else bg-slate-400 @endif">
                            </span>
                            {{ ucfirst($invitation->status) }}
                        </span>
                    </div>
                </div>

                {{-- Message --}}
                <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                    Tu as été invité(e) à rejoindre cette colocation. Valide l'invitation pour accéder aux dépenses partagées, aux membres et à tous les outils EasyColoc.
                </p>

                {{-- Actions --}}
                @if ($invitation->status === 'pending')
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">
                        <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full bg-primary text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform flex items-center justify-center gap-2 text-sm">
                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                Accepter l'invitation
                            </button>
                        </form>

                        <form method="POST" action="{{ route('invitations.decline', $invitation->token) }}" class="flex-1">
                            @csrf
                            <button type="submit"
                                class="w-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-semibold py-3 px-4 rounded-xl hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors text-sm">
                                Refuser
                            </button>
                        </form>
                    </div>
                @else
                    <div class="pt-2">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary/10 text-primary rounded-xl text-sm font-semibold hover:bg-primary/20 transition-colors">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            Retour au tableau de bord
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

</x-dashboard-layout>
