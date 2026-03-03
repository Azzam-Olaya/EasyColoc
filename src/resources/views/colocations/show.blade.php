<x-dashboard-layout
    title="{{ $colocation->name }}"
    subtitle="Gérez les dépenses et membres de votre colocation"
    activeNav="expenses"
    :activeColocation="$colocation"
    backUrl="{{ route('colocations.index') }}"
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

    {{-- ===== STAT CARDS ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-primary/5 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">Balance colocation</p>
                <p class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $globalBalance ?? '—' }}</p>
                <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 rounded-full bg-primary/10 text-primary text-[10px] font-bold">
                    Suivi des paiements
                </span>
            </div>
            <div class="h-12 w-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">account_balance_wallet</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-primary/5 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Membres actifs</p>
                <p class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ count($activeMembers) }}</p>
                <span class="inline-flex items-center gap-1 mt-2 px-2.5 py-0.5 rounded-full bg-primary/10 text-primary text-[10px] font-bold">
                    Gestion en douceur
                </span>
            </div>
            <div class="h-12 w-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">group</span>
            </div>
        </div>
    </div>

    {{-- ===== ADMIN QUICK ACTIONS ===== --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800 dark:text-white">Actions rapides</h3>
            @if (isset($colocation->status))
                <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-semibold">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    {{ $colocation->status }}
                </span>
            @endif
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @if ($isOwner)
                {{-- Invite member --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-primary/5 shadow-sm p-5 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 bg-primary text-white rounded-lg flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">person_add</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Inviter un membre</h4>
                            <p class="text-[11px] text-slate-400">Par email ou lien magique</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('invitations.store', $colocation) }}" class="space-y-2 mt-1">
                        @csrf
                        <div>
                            <x-input-label for="invite_email" value="Email" />
                            <x-text-input id="invite_email" name="email" type="email" class="mt-1 block w-full" required />
                            <x-input-error class="mt-1" :messages="$errors->get('email')" />
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm hover:bg-primary/90 transition-colors">
                            Créer le lien
                        </button>
                    </form>
                </div>

                {{-- Categories --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-primary/5 shadow-sm p-5 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 bg-primary text-white rounded-lg flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">category</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Catégories</h4>
                            <p class="text-[11px] text-slate-400">Organiser les dépenses</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('categories.store', $colocation) }}" class="space-y-2 mt-1">
                        @csrf
                        <div>
                            <x-input-label for="category_name" value="Nom de catégorie" />
                            <x-text-input id="category_name" name="name" type="text" class="mt-1 block w-full" required />
                            <x-input-error class="mt-1" :messages="$errors->get('name')" />
                        </div>
                        <button type="submit"
                            class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm hover:bg-primary/90 transition-colors">
                            Ajouter
                        </button>
                    </form>
                </div>

                {{-- Danger zone --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-red-100 dark:border-red-900/20 shadow-sm p-5 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 bg-red-50 text-red-500 rounded-lg flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-sm">warning</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-900 dark:text-white">Gestion avancée</h4>
                            <p class="text-[11px] text-slate-400">Annuler la colocation</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('colocations.cancel', $colocation) }}"
                        onsubmit="return confirm('Annuler cette colocation ?');" class="mt-1">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded-lg font-bold text-sm hover:bg-red-600 transition-colors">
                            Annuler la colocation
                        </button>
                    </form>
                </div>
            @else
                <div class="col-span-full bg-white dark:bg-slate-900 rounded-xl border border-primary/5 shadow-sm p-6">
                    <p class="text-sm text-slate-600 dark:text-slate-300">
                        Tu es membre de la colocation <span class="font-semibold text-slate-900 dark:text-white">{{ $colocation->name }}</span>. Les actions d'administration sont réservées à l'owner.
                    </p>
                </div>
            @endif
        </div>
    </div>

    {{-- ===== MEMBERS & FILTER ===== --}}
    <div id="members" class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">

            {{-- Members list --}}
            <div class="flex-1">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Membres</p>
                <div class="space-y-3">
                    @foreach ($activeMembers as $m)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="h-9 w-9 rounded-full bg-primary/10 flex items-center justify-center text-primary text-sm shrink-0">
                                    <span class="material-symbols-outlined text-sm">
                                        {{ $m->pivot->role === 'owner' ? 'star' : 'person' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ $m->name }}</p>
                                    <p class="text-[10px] uppercase tracking-widest font-semibold text-slate-400">{{ $m->pivot->role }}</p>
                                </div>
                            </div>
                            @if (auth()->user()?->is_global_admin)
                                <form method="POST"
                                    action="{{ route('admin.colocations.users.role', [$colocation, $m]) }}"
                                    class="flex items-center gap-1.5">
                                    @csrf
                                    <select name="role"
                                        class="border-primary/20 bg-background-light dark:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-full text-xs px-2 py-1 focus:border-primary focus:ring-primary/30">
                                        <option value="member" @selected($m->pivot->role === 'member')>Membre</option>
                                        <option value="owner" @selected($m->pivot->role === 'owner')>Owner</option>
                                    </select>
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-primary text-white rounded-lg font-bold text-xs hover:bg-primary/90 transition-colors">
                                        OK
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Month filter --}}
            <form method="GET" action="{{ route('colocations.show', $colocation) }}"
                class="flex items-end gap-3 bg-background-light dark:bg-slate-800/50 rounded-xl p-4 shrink-0">
                <div>
                    <x-input-label for="month" value="Filtrer par mois" />
                    <select id="month" name="month"
                        class="mt-1 border-primary/20 bg-white dark:bg-slate-900 text-sm rounded-xl px-4 py-2 focus:border-primary focus:ring-primary/30">
                        <option value="all" @selected($month === 'all')>Tous</option>
                        @foreach ($months as $m)
                            <option value="{{ $m }}" @selected($month === $m)>{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-primary text-white rounded-lg font-bold text-sm hover:bg-primary/90 transition-colors">
                    OK
                </button>
            </form>
        </div>
    </div>

    {{-- ===== ADD EXPENSE FORM ===== --}}
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
        <div class="flex items-center gap-3 mb-5">
            <div class="h-9 w-9 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-sm">add_card</span>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Ajouter une dépense</h3>
            </div>
        </div>
        <form method="POST" action="{{ route('expenses.store', $colocation) }}"
            class="grid grid-cols-1 md:grid-cols-6 gap-4">
            @csrf

            <div class="md:col-span-2">
                <x-input-label for="expense_title" value="Titre" />
                <x-text-input id="expense_title" name="title" type="text"
                    class="mt-1 block w-full" required value="{{ old('title') }}" />
                <x-input-error class="mt-1" :messages="$errors->get('title')" />
            </div>

            <div>
                <x-input-label for="expense_amount" value="Montant" />
                <x-text-input id="expense_amount" name="amount" type="number" step="0.01"
                    min="0.01" class="mt-1 block w-full" required value="{{ old('amount') }}" />
                <x-input-error class="mt-1" :messages="$errors->get('amount')" />
            </div>

            <div>
                <x-input-label for="expense_spent_at" value="Date" />
                <x-text-input id="expense_spent_at" name="spent_at" type="date"
                    class="mt-1 block w-full" required
                    value="{{ old('spent_at', now()->toDateString()) }}" />
                <x-input-error class="mt-1" :messages="$errors->get('spent_at')" />
            </div>

            <div>
                <x-input-label for="expense_category" value="Catégorie" />
                <select id="expense_category" name="category_id"
                    class="mt-1 border-primary/20 bg-white dark:bg-slate-900 rounded-xl px-3 py-2 text-sm w-full focus:border-primary focus:ring-primary/30">
                    <option value="">(Aucune)</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-1" :messages="$errors->get('category_id')" />
            </div>

            <div>
                <x-input-label for="expense_paid_by" value="Payeur" />
                <select id="expense_paid_by" name="paid_by_user_id"
                    class="mt-1 border-primary/20 bg-white dark:bg-slate-900 rounded-xl px-3 py-2 text-sm w-full focus:border-primary focus:ring-primary/30"
                    required>
                    @foreach ($activeMembers as $m)
                        <option value="{{ $m->id }}"
                            @selected((int) old('paid_by_user_id', auth()->id()) === (int) $m->id)>
                            {{ $m->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error class="mt-1" :messages="$errors->get('paid_by_user_id')" />
            </div>

            <div class="md:col-span-6">
                <x-primary-button>Ajouter</x-primary-button>
            </div>
        </form>
    </div>

    {{-- ===== BALANCES & SETTLEMENTS ===== --}}
    <div id="balances" class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Balances --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">Balances</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Qui est en avance ou en retard</p>
                </div>
                <div class="h-9 w-9 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">balance</span>
                </div>
            </div>
            <div class="space-y-2">
                @foreach ($balances as $row)
                    <div class="flex items-center justify-between rounded-xl bg-background-light dark:bg-slate-800/50 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <div class="h-7 w-7 rounded-full bg-primary/10 flex items-center justify-center text-primary text-[10px] font-bold">
                                {{ strtoupper(substr($row['user']->name, 0, 2)) }}
                            </div>
                            <span class="text-sm text-slate-800 dark:text-slate-100 font-medium">{{ $row['user']->name }}</span>
                        </div>
                        <span class="text-sm font-mono font-bold {{ $row['balance_cents'] >= 0 ? 'text-emerald-600' : 'text-red-500' }}">
                            {{ $formatCents($row['balance_cents']) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Settlements --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">Qui doit à qui</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Petits remboursements, zéro prise de tête</p>
                </div>
                <div class="h-9 w-9 bg-purple-50 text-purple-500 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">sync_alt</span>
                </div>
            </div>

            @if (count($settlements) === 0)
                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl px-4 py-3 text-sm text-green-700 dark:text-green-300 font-medium flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Tout est parfaitement équilibré. ✨
                </div>
            @else
                <div class="space-y-3">
                    @foreach ($settlements as $s)
                        <div class="flex items-center justify-between gap-3 rounded-xl bg-background-light dark:bg-slate-800/50 px-4 py-3">
                            <div class="text-sm text-slate-800 dark:text-slate-100">
                                <span class="font-bold">{{ $s['from']->name }}</span>
                                <span class="text-slate-500 mx-1">doit</span>
                                <span class="font-bold">{{ $s['to']->name }}</span>
                            </div>
                            <div class="flex items-center gap-3 shrink-0">
                                <span class="text-sm font-mono text-primary font-bold">{{ $formatCents($s['amount_cents']) }}</span>
                                <form method="POST" action="{{ route('payments.store', $colocation) }}">
                                    @csrf
                                    <input type="hidden" name="to_user_id" value="{{ $s['to']->id }}">
                                    <input type="hidden" name="amount" value="{{ $formatCents($s['amount_cents']) }}">
                                    <button type="submit"
                                        class="px-3 py-1.5 bg-primary text-white rounded-lg font-bold text-xs hover:bg-primary/90 transition-colors">
                                        Marquer payé
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ===== EXPENSES TABLE & PAYMENTS ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Expenses Table --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">Dépenses</h3>
                <div class="h-9 w-9 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">receipt_long</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800">
                            <th class="pb-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="pb-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Titre</th>
                            <th class="pb-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cat.</th>
                            <th class="pb-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Payeur</th>
                            <th class="pb-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @foreach ($expenses as $e)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-3 text-xs font-mono text-slate-500">{{ $e->spent_at->format('Y-m-d') }}</td>
                                <td class="py-3 text-sm font-semibold text-slate-900 dark:text-white">{{ $e->title }}</td>
                                <td class="py-3">
                                    @if ($e->category?->name)
                                        <span class="px-2 py-0.5 rounded-full bg-primary/10 text-primary text-[10px] font-bold">{{ $e->category->name }}</span>
                                    @else
                                        <span class="text-slate-400 text-xs">—</span>
                                    @endif
                                </td>
                                <td class="py-3 text-sm text-slate-600 dark:text-slate-400">{{ $e->paidBy?->name }}</td>
                                <td class="py-3 text-right text-sm font-mono font-bold text-slate-900 dark:text-white">
                                    {{ number_format((float) $e->amount, 2, '.', '') }} €
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($expenses->count() === 0)
                    <div class="mt-4 text-sm text-slate-500 bg-background-light dark:bg-slate-800/50 rounded-xl px-4 py-3">
                        Aucune dépense pour le moment.
                    </div>
                @endif
            </div>
        </div>

        {{-- Recorded Payments --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-primary/5 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-bold text-slate-900 dark:text-slate-100 uppercase tracking-widest">Paiements enregistrés</h3>
                <div class="h-9 w-9 bg-green-50 text-green-500 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-sm">payments</span>
                </div>
            </div>
            <div class="space-y-2">
                @foreach ($payments as $p)
                    <div class="flex items-center justify-between rounded-xl bg-background-light dark:bg-slate-800/50 px-4 py-3">
                        <div class="text-sm text-slate-800 dark:text-slate-100">
                            <span class="font-bold">{{ $p->fromUser?->name }}</span>
                            <span class="mx-1 text-slate-400">→</span>
                            <span class="font-bold">{{ $p->toUser?->name }}</span>
                            <span class="block text-[11px] text-slate-400 mt-0.5">(par {{ $p->createdBy?->name }})</span>
                        </div>
                        <span class="text-sm font-mono text-primary font-bold">
                            {{ number_format((float) $p->amount, 2, '.', '') }} €
                        </span>
                    </div>
                @endforeach

                @if ($payments->count() === 0)
                    <div class="text-sm text-slate-500 bg-background-light dark:bg-slate-800/50 rounded-xl px-4 py-3">
                        Aucun paiement enregistré pour le moment.
                    </div>
                @endif
            </div>
        </div>

    </div>

</x-dashboard-layout>
