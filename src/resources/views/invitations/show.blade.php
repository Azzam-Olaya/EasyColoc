<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="size-10 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">mail</span>
                </div>
                <div>
                    <p class="text-xs text-primary font-semibold uppercase tracking-widest">Invitation</p>
                    <h2 class="text-slate-900 dark:text-slate-100 text-lg font-bold leading-tight">
                        Rejoindre une colocation
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-md mx-auto px-4 py-6 space-y-6 sm:max-w-xl">
        @if (session('error'))
            <div
                class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <div
            class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-primary/10 border border-primary/10 p-6 space-y-5">
            <div class="flex items-center gap-3">
                <div
                    class="size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary text-2xl">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Colocation</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-slate-100">
                        {{ $invitation->colocation?->name }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Email invité</p>
                    <p class="font-mono text-sm text-slate-800 dark:text-slate-100">
                        {{ $invitation->email }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-slate-500 font-medium uppercase tracking-widest">Statut</p>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                        @if ($invitation->status === 'pending') bg-amber-100 text-amber-700
                        @elseif($invitation->status === 'accepted') bg-emerald-100 text-emerald-700
                        @else bg-slate-200 text-slate-700 @endif">
                        {{ ucfirst($invitation->status) }}
                    </span>
                </div>
            </div>

            <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                Tu as été invitée à rejoindre cette colocation. Valide l'invitation pour accéder aux
                dépenses partagées, aux membres et à tous les outils EasyColoc.
            </p>

            @if ($invitation->status === 'pending')
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <form method="POST" action="{{ route('invitations.accept', $invitation->token) }}"
                        class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-base">check_circle</span>
                            Accepter l'invitation
                        </button>
                    </form>

                    <form method="POST" action="{{ route('invitations.decline', $invitation->token) }}"
                        class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full bg-background-light dark:bg-background-dark/60 text-slate-700 dark:text-slate-200 border border-primary/10 font-semibold py-3 px-4 rounded-xl hover:bg-primary/5 transition-all text-sm">
                            Refuser
                        </button>
                    </form>
                </div>
            @else
                <div class="pt-2">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                        <span class="material-symbols-outlined text-sm">arrow_back</span>
                        Retour au tableau de bord
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
