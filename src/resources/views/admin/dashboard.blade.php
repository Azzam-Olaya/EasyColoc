<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-primary p-2 rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">dashboard_customize</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold leading-tight tracking-tight text-slate-900 dark:text-slate-100">
                        EasyColoc Admin
                    </h2>
                    <p class="text-xs text-primary font-medium">Global Access Control</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto w-full px-4 py-6 lg:px-8 space-y-6">
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

        <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-slate-900 border border-primary/5 shadow-sm md:col-span-1">
                <div class="flex justify-between items-start">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Utilisateurs</p>
                    <span
                        class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">groups</span>
                </div>
                <p class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl font-bold">
                    {{ $stats['users'] }}
                </p>
                <p class="text-xs text-slate-400">Comptes créés</p>
            </div>

            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-slate-900 border border-primary/5 shadow-sm md:col-span-1">
                <div class="flex justify-between items-start">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Utilisateurs bannis</p>
                    <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">block</span>
                </div>
                <p class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl font-bold">
                    {{ $stats['banned_users'] }}
                </p>
                <p class="text-xs text-slate-400">Sous surveillance</p>
            </div>

            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-slate-900 border border-primary/5 shadow-sm md:col-span-1">
                <div class="flex justify-between items-start">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Colocations</p>
                    <span
                        class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">home_work</span>
                </div>
                <p class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl font-bold">
                    {{ $stats['colocations'] }}
                </p>
                <p class="text-xs text-slate-400">Espaces actifs</p>
            </div>

            <div
                class="flex flex-col gap-2 rounded-xl p-6 bg-white dark:bg-slate-900 border border-primary/5 shadow-sm md:col-span-1">
                <div class="flex justify-between items-start">
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Dépenses</p>
                    <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg">payments</span>
                </div>
                <p class="text-slate-900 dark:text-slate-100 tracking-tight text-3xl font-bold">
                    {{ $stats['expenses'] }}
                </p>
                <p class="text-xs text-slate-400">Enregistrements totaux</p>
            </div>
        </section>

        <section
            class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-primary/5 shadow-sm space-y-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Aperçu plateforme</h3>
                    <p class="text-slate-500 text-sm">Tendances globales de l'activité</p>
                </div>
                <div class="flex gap-2">
                    <button
                        class="px-4 py-2 rounded-full bg-primary text-white text-sm font-semibold">Hebdomadaire</button>
                    <button
                        class="px-4 py-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-sm font-semibold">Mensuel</button>
                </div>
            </div>
            <div class="h-[220px] w-full mt-2">
                <svg class="w-full h-full" viewBox="0 0 478 150" fill="none"
                    preserveAspectRatio="none">
                    <path
                        d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25V149H326.769H0V109Z"
                        fill="url(#chartGradient)"></path>
                    <path
                        d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25"
                        stroke="#ee2b8c" stroke-width="3" stroke-linecap="round"></path>
                    <defs>
                        <linearGradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
                            <stop offset="0%" stop-color="#ee2b8c" stop-opacity="0.2" />
                            <stop offset="100%" stop-color="#ee2b8c" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <div class="flex justify-between px-2 mt-2 text-xs font-bold text-slate-400">
                <span>SEM 1</span>
                <span>SEM 2</span>
                <span>SEM 3</span>
                <span>SEM 4</span>
            </div>
        </section>

        <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div
                class="xl:col-span-2 bg-white dark:bg-slate-900 rounded-xl border border-primary/5 shadow-sm overflow-hidden flex flex-col">
                <div
                    class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Utilisateurs</h3>
                        <p class="text-slate-500 text-sm">Gestion des rôles et bannissements</p>
                    </div>
                    <div class="relative w-full sm:w-64">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                        <input type="text" placeholder="Recherche (visuelle seulement)…"
                            class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-sm focus:ring-2 focus:ring-primary/50" />
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr
                                class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider font-semibold">
                                <th class="px-6 py-3">Nom</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Admin</th>
                                <th class="px-6 py-3">Banni</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($users as $u)
                                <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="size-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs">
                                                <span class="material-symbols-outlined">
                                                    {{ $u->is_global_admin ? 'shield_person' : 'person' }}
                                                </span>
                                            </div>
                                            <span class="font-medium text-slate-900 dark:text-slate-100">
                                                {{ $u->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 font-mono text-xs text-slate-600 dark:text-slate-300">
                                        {{ $u->email }}
                                    </td>
                                    <td class="px-6 py-3 text-slate-600 dark:text-slate-300">
                                        {{ $u->is_global_admin ? 'oui' : 'non' }}
                                    </td>
                                    <td class="px-6 py-3">
                                        @if ($u->is_banned)
                                            <span
                                                class="px-2 py-1 rounded-full bg-red-100 text-red-700 text-[10px] font-bold uppercase">
                                                Banni
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-bold uppercase">
                                                Actif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            @if ($u->is_banned)
                                                <form method="POST"
                                                    action="{{ route('admin.users.unban', $u) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[11px] font-semibold hover:bg-emerald-100">
                                                        Débannir
                                                    </button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('admin.users.ban', $u) }}">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-3 py-1 rounded-full bg-red-50 text-red-700 text-[11px] font-semibold hover:bg-red-100">
                                                        Bannir
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div
                    class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/30 flex items-center justify-between text-xs text-slate-500">
                    <span>Pagination Laravel</span>
                    <div class="text-right">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-slate-900 rounded-xl border border-primary/5 shadow-sm overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Modération rapide</h3>
                    <p class="text-slate-500 text-sm">Suivi des comptes bannis</p>
                </div>
                <div class="p-4 space-y-3 text-sm">
                    <div
                        class="p-3 rounded-lg border border-slate-100 dark:border-slate-800 bg-slate-50/40 dark:bg-slate-800/30">
                        <p class="font-semibold text-slate-800 dark:text-slate-100 mb-1">Utilisateurs bannis</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Total : <span class="font-bold text-red-500">{{ $stats['banned_users'] }}</span>
                        </p>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                        Cette zone admin garde un style doux et lisible tout en restant claire pour la
                        modération : couleurs pastel, arrondis généreux et hiérarchie visuelle simple.
                    </p>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
