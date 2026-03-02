<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="flex size-10 shrink-0 items-center overflow-hidden rounded-full ring-2 ring-primary/20 bg-primary/10 text-primary">
                    <span class="material-symbols-outlined">home_work</span>
                </div>
                <div>
                    <p class="text-xs text-primary font-semibold uppercase tracking-wider">Owner Dashboard</p>
                    <h2 class="text-slate-900 dark:text-slate-100 text-lg font-bold leading-tight">
                        {{ $colocation->name }}
                    </h2>
                </div>
            </div>
            <div class="hidden sm:flex gap-2 items-center text-xs text-slate-500 dark:text-slate-400">
                <span
                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-soft-lavender/60 dark:bg-primary/20 text-primary font-semibold">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    Statut : {{ $colocation->status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="max-w-md mx-auto px-4 py-6 space-y-6 sm:max-w-4xl">
        @if (session('status'))
            <div
                class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200 px-4 py-3 rounded-xl">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-wrap gap-4">
            <div
                class="flex min-w-[230px] flex-1 flex-col gap-2 rounded-xl p-5 bg-primary/5 border border-primary/10">
                <div class="flex items-center justify-between">
                    <p class="text-slate-600 dark:text-slate-400 text-sm font-medium">Balance colocation</p>
                    <span class="material-symbols-outlined text-primary text-xl">account_balance_wallet</span>
                </div>
                <p class="text-slate-900 dark:text-slate-100 tracking-tight text-2xl font-extrabold leading-tight">
                    {{ $globalBalance ?? '—' }}
                </p>
                <p class="text-emerald-600 text-xs font-bold bg-emerald-100 px-2 py-0.5 rounded-full w-fit">
                    Suivi des paiements
                </p>
            </div>
            <div
                class="flex min-w-[230px] flex-1 flex-col gap-2 rounded-xl p-5 bg-slate-50 dark:bg-primary/5 border border-slate-100 dark:border-primary/10">
                <div class="flex items-center justify-between">
                    <p class="text-slate-600 dark:text-slate-400 text-sm font-medium">Membres actifs</p>
                    <span class="material-symbols-outlined text-primary text-xl">group</span>
                </div>
                <p class="text-slate-900 dark:text-slate-100 tracking-tight text-2xl font-extrabold leading-tight">
                    {{ count($activeMembers) }}
                </p>
                <p class="text-primary text-xs font-bold bg-primary/10 px-2 py-0.5 rounded-full w-fit">
                    Gestion en douceur
                </p>
            </div>
        </div>

        <section class="px-0 pt-2">
            <h2 class="text-slate-900 dark:text-slate-100 text-xl font-bold mb-4">Actions rapides</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @if ($isOwner)
                    <div
                        class="flex flex-col items-start gap-3 rounded-xl border border-primary/10 bg-white dark:bg-primary/5 p-4 text-left">
                        <div class="bg-primary text-white p-2 rounded-lg">
                            <span class="material-symbols-outlined">person_add</span>
                        </div>
                        <div class="space-y-2 w-full">
                            <h3 class="text-slate-900 dark:text-slate-100 text-sm font-bold">Inviter un membre</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs">Par email ou lien magique</p>
                            <form method="POST" action="{{ route('invitations.store', $colocation) }}"
                                class="space-y-2">
                                @csrf
                                <div>
                                    <x-input-label for="invite_email" value="Email" />
                                    <x-text-input id="invite_email" name="email" type="email"
                                        class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>
                                <x-primary-button>Créer le lien</x-primary-button>
                            </form>
                        </div>
                    </div>

                    <div
                        class="flex flex-col items-start gap-3 rounded-xl border border-primary/10 bg-white dark:bg-primary/5 p-4 text-left">
                        <div class="bg-primary text-white p-2 rounded-lg">
                            <span class="material-symbols-outlined">category</span>
                        </div>
                        <div class="space-y-2 w-full">
                            <h3 class="text-slate-900 dark:text-slate-100 text-sm font-bold">Catégories</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs">Organiser les dépenses</p>
                            <form method="POST" action="{{ route('categories.store', $colocation) }}"
                                class="space-y-2">
                                @csrf
                                <div>
                                    <x-input-label for="category_name" value="Nom de catégorie" />
                                    <x-text-input id="category_name" name="name" type="text"
                                        class="mt-1 block w-full" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                                <x-primary-button>Ajouter</x-primary-button>
                            </form>
                        </div>
                    </div>

                    <div
                        class="flex flex-col items-start gap-3 rounded-xl border border-primary/10 bg-white dark:bg-primary/5 p-4 text-left">
                        <div class="bg-slate-900 text-white p-2 rounded-lg">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                        <div class="space-y-2 w-full">
                            <h3 class="text-slate-900 dark:text-slate-100 text-sm font-bold">Gestion avancée</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs">Annuler la colocation</p>
                            <form method="POST" action="{{ route('colocations.cancel', $colocation) }}"
                                onsubmit="return confirm('Annuler cette colocation ?');">
                                @csrf
                                <x-danger-button>Annuler la colocation</x-danger-button>
                            </form>
                        </div>
                    </div>
                @else
                    <div
                        class="col-span-full bg-white dark:bg-slate-900/60 rounded-2xl border border-primary/10 p-6">
                        <p class="text-sm text-slate-600 dark:text-slate-300">
                            Tu es membre de la colocation <span class="font-semibold">{{ $colocation->name }}</span>. Les
                            actions d'administration sont réservées à l'owner.
                        </p>
                    </div>
                @endif
            </div>
        </section>

        <section class="bg-white dark:bg-slate-900 rounded-2xl border border-primary/10 shadow-sm p-6 space-y-6">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div class="space-y-2">
                    <p
                        class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase tracking-widest">
                        Membres</p>
                    <div class="space-y-2">
                        @foreach ($activeMembers as $m)
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm">
                                        <span class="material-symbols-outlined">
                                            {{ $m->pivot->role === 'owner' ? 'star' : 'person' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-semibold text-slate-900 dark:text-slate-100">
                                            {{ $m->name }}
                                        </p>
                                        <p
                                            class="text-[11px] uppercase tracking-widest font-semibold text-slate-400">
                                            {{ $m->pivot->role }}
                                        </p>
                                    </div>
                                </div>
                                @if (auth()->user()?->is_global_admin)
                                    <form method="POST"
                                        action="{{ route('admin.colocations.users.role', [$colocation, $m]) }}"
                                        class="flex items-center gap-1 text-xs">
                                        @csrf
                                        <select name="role"
                                            class="border-primary/20 bg-background-light dark:bg-background-dark/60 text-slate-700 dark:text-slate-200 rounded-full text-xs px-2 py-1 focus:border-primary focus:ring-primary/30">
                                            <option value="member" @selected($m->pivot->role === 'member')>Membre
                                            </option>
                                            <option value="owner" @selected($m->pivot->role === 'owner')>Owner
                                            </option>
                                        </select>
                                        <button type="submit"
                                            class="px-2 py-1 rounded-full bg-primary text-white text-[11px] font-bold">
                                            OK
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <form method="GET" action="{{ route('colocations.show', $colocation) }}"
                    class="flex items-end gap-3 bg-background-light dark:bg-background-dark/60 rounded-xl p-3">
                    <div>
                        <x-input-label for="month" value="Filtrer par mois" />
                        <select id="month" name="month"
                            class="mt-1 border-primary/20 bg-white dark:bg-slate-900 text-sm rounded-full px-4 py-2 focus:border-primary focus:ring-primary/30">
                            <option value="all" @selected($month === 'all')>Tous</option>
                            @foreach ($months as $m)
                                <option value="{{ $m }}" @selected($month === $m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button>OK</x-primary-button>
                </form>
            </div>

            <div class="border-t border-primary/10 pt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100">Ajouter une dépense</h3>
                </div>
                <form method="POST" action="{{ route('expenses.store', $colocation) }}"
                    class="grid grid-cols-1 md:grid-cols-6 gap-3">
                    @csrf

                    <div class="md:col-span-2">
                        <x-input-label for="expense_title" value="Titre" />
                        <x-text-input id="expense_title" name="title" type="text"
                            class="mt-1 block w-full" required value="{{ old('title') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="expense_amount" value="Montant" />
                        <x-text-input id="expense_amount" name="amount" type="number" step="0.01"
                            min="0.01" class="mt-1 block w-full" required value="{{ old('amount') }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                    </div>

                    <div>
                        <x-input-label for="expense_spent_at" value="Date" />
                        <x-text-input id="expense_spent_at" name="spent_at" type="date"
                            class="mt-1 block w-full" required
                            value="{{ old('spent_at', now()->toDateString()) }}" />
                        <x-input-error class="mt-2" :messages="$errors->get('spent_at')" />
                    </div>

                    <div>
                        <x-input-label for="expense_category" value="Catégorie" />
                        <select id="expense_category" name="category_id"
                            class="mt-1 border-primary/20 bg-white dark:bg-slate-900 rounded-full px-3 py-2 text-sm w-full focus:border-primary focus:ring-primary/30">
                            <option value="">(Aucune)</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                    </div>

                    <div>
                        <x-input-label for="expense_paid_by" value="Payeur" />
                        <select id="expense_paid_by" name="paid_by_user_id"
                            class="mt-1 border-primary/20 bg-white dark:bg-slate-900 rounded-full px-3 py-2 text-sm w-full focus:border-primary focus:ring-primary/30"
                            required>
                            @foreach ($activeMembers as $m)
                                <option value="{{ $m->id }}"
                                    @selected((int) old('paid_by_user_id', auth()->id()) === (int) $m->id)>
                                    {{ $m->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('paid_by_user_id')" />
                    </div>

                    <div class="md:col-span-6">
                        <x-primary-button>Ajouter</x-primary-button>
                    </div>
                </form>
            </div>
        </section>

        <section id="balances" class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-primary/10 p-5 space-y-3">
                <div class="flex items-center justify-between mb-1">
                    <div>
                        <h3
                            class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">
                            Balances
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Qui est en avance ou en
                            retard</p>
                    </div>
                    <span class="material-symbols-outlined text-primary">balance</span>
                </div>
                <div class="space-y-2">
                    @foreach ($balances as $row)
                        <div
                            class="flex items-center justify-between rounded-xl bg-background-light dark:bg-background-dark/60 px-3 py-2">
                            <div class="text-sm text-slate-800 dark:text-slate-100">
                                {{ $row['user']->name }}</div>
                            <div
                                class="text-sm font-mono {{ $row['balance_cents'] >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                                {{ $formatCents($row['balance_cents']) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-primary/10 p-5 space-y-3">
                <div class="flex items-center justify-between mb-1">
                    <div>
                        <h3
                            class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">
                            Qui doit à qui</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Petits remboursements, zéro
                            prise de tête</p>
                    </div>
                    <span class="material-symbols-outlined text-primary">sync_alt</span>
                </div>

                @if (count($settlements) === 0)
                    <div
                        class="text-sm text-slate-600 dark:text-slate-300 bg-background-light dark:bg-background-dark/60 rounded-xl px-4 py-3">
                        Tout est parfaitement équilibré. ✨
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach ($settlements as $s)
                            <div
                                class="flex items-center justify-between gap-3 rounded-xl bg-background-light dark:bg-background-dark/60 px-3 py-2">
                                <div class="text-sm">
                                    <span class="font-semibold">{{ $s['from']->name }}</span>
                                    doit
                                    <span class="font-semibold">{{ $s['to']->name }}</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <div class="text-sm font-mono text-primary">
                                        {{ $formatCents($s['amount_cents']) }}
                                    </div>

                                    <form method="POST"
                                        action="{{ route('payments.store', $colocation) }}">
                                        @csrf
                                        <input type="hidden" name="to_user_id"
                                            value="{{ $s['to']->id }}">
                                        <input type="hidden" name="amount"
                                            value="{{ $formatCents($s['amount_cents']) }}">
                                        <x-secondary-button>Marquer payé</x-secondary-button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-primary/10 p-5">
                <div class="flex items-center justify-between mb-3">
                    <h3
                        class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">
                        Dépenses</h3>
                    <span class="material-symbols-outlined text-primary">receipt_long</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs md:text-sm">
                        <thead>
                            <tr class="text-left text-slate-500 dark:text-slate-400">
                                <th class="py-2 pr-4">Date</th>
                                <th class="py-2 pr-4">Titre</th>
                                <th class="py-2 pr-4">Cat.</th>
                                <th class="py-2 pr-4">Payeur</th>
                                <th class="py-2 pr-4 text-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($expenses as $e)
                                <tr
                                    class="hover:bg-background-light/60 dark:hover:bg-background-dark/60">
                                    <td class="py-2 pr-4 font-mono text-xs">
                                        {{ $e->spent_at->format('Y-m-d') }}
                                    </td>
                                    <td class="py-2 pr-4">{{ $e->title }}</td>
                                    <td class="py-2 pr-4">{{ $e->category?->name ?? '-' }}</td>
                                    <td class="py-2 pr-4">{{ $e->paidBy?->name }}</td>
                                    <td class="py-2 pr-4 text-right font-mono">
                                        {{ number_format((float) $e->amount, 2, '.', '') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if ($expenses->count() === 0)
                        <div
                            class="text-sm text-slate-600 dark:text-slate-300 mt-3 bg-background-light dark:bg-background-dark/60 rounded-xl px-4 py-3">
                            Aucune dépense pour le moment.
                        </div>
                    @endif
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 rounded-2xl border border-primary/10 p-5 space-y-3">
                <div class="flex items-center justify-between mb-1">
                    <h3
                        class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">
                        Paiements enregistrés
                    </h3>
                    <span class="material-symbols-outlined text-primary">payments</span>
                </div>
                <div class="space-y-2">
                    @foreach ($payments as $p)
                        <div
                            class="flex items-center justify-between rounded-xl bg-background-light dark:bg-background-dark/60 px-3 py-2">
                            <div class="text-xs md:text-sm">
                                <span class="font-semibold">{{ $p->fromUser?->name }}</span>
                                →
                                <span class="font-semibold">{{ $p->toUser?->name }}</span>
                                <span
                                    class="text-slate-500 dark:text-slate-400 text-[11px]">
                                    (par {{ $p->createdBy?->name }})
                                </span>
                            </div>
                            <div class="text-xs md:text-sm font-mono text-primary">
                                {{ number_format((float) $p->amount, 2, '.', '') }}
                            </div>
                        </div>
                    @endforeach

                    @if ($payments->count() === 0)
                        <div
                            class="text-sm text-slate-600 dark:text-slate-300 bg-background-light dark:bg-background-dark/60 rounded-xl px-4 py-3">
                            Aucun paiement enregistré pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
</x-app-layout>

