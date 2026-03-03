<x-dashboard-layout
    title="Dashboard"
    subtitle="Welcome back, {{ auth()->user()->name }}"
    activeNav="dashboard"
    :activeColocation="$activeColocation ?? null"
    :showSearch="true"
>

    {{-- Session Messages --}}
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- LEFT 2/3 --}}
            <div class="lg:col-span-2 space-y-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Colocation Card --}}
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-primary/5 flex flex-col justify-between">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">Current Home</p>
                                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $activeColocation->name ?? '—' }}</h2>
                                <p class="text-xs text-slate-400 mt-1">Owner : {{ $activeColocation->owner?->name }}</p>
                            </div>
                            <div class="h-10 w-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined">apartment</span>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-2">
                            <div class="flex -space-x-2">
                                @foreach ($activeColocation->members->take(3) as $member)
                                    <div class="inline-flex h-6 w-6 rounded-full ring-2 ring-white dark:ring-slate-900 bg-primary/10 items-center justify-center text-primary text-[9px] font-bold">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                @endforeach
                            </div>
                            @if ($activeColocation->members->count() > 3)
                                <p class="text-xs text-slate-500 font-medium">+ {{ $activeColocation->members->count() - 3 }} others active</p>
                            @endif
                        </div>
                    </div>

                    {{-- Reputation Card --}}
                    @php $reputation = (int) (auth()->user()->reputation_score ?? 0); @endphp
                    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-sm border border-primary/5">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Reputation Score</p>
                                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">
                                    {{ $reputation }}<span class="text-sm font-normal text-slate-400">/100</span>
                                </h2>
                            </div>
                            <div class="h-10 w-10 bg-amber-50 text-amber-500 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined">stars</span>
                            </div>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-amber-400 to-primary h-full rounded-full" style="width: {{ min(100, $reputation) }}%"></div>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-3 font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px] text-green-500">trending_up</span>
                            Top 5% of roommates this month
                        </p>
                    </div>

                </div>

                {{-- CTA Banner --}}
                <div class="relative overflow-hidden bg-primary rounded-xl p-8 text-white shadow-xl shadow-primary/20">
                    <div class="relative z-10">
                        <h3 class="text-2xl font-extrabold mb-2">Ready to settle up?</h3>
                        <p class="text-white/80 mb-6 max-w-md">Review all pending expenses for your colocation and stay on top of your bills.</p>
                        <a href="{{ route('colocations.show', $activeColocation) }}"
                           class="inline-flex items-center gap-2 px-6 py-3 bg-white text-primary rounded-lg font-bold text-sm hover:scale-105 transition-transform">
                            See all expenses
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                    <div class="absolute -right-8 -bottom-8 opacity-20 transform rotate-12">
                        <span class="material-symbols-outlined text-[200px]">payments</span>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <a href="{{ route('colocations.show', $activeColocation) }}"
                           class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-primary/5 hover:border-primary/30 transition-all text-center space-y-2">
                            <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center mx-auto">
                                <span class="material-symbols-outlined">add_card</span>
                            </div>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">New Expense</p>
                        </a>
                        <a href="{{ route('colocations.show', $activeColocation) }}#balances"
                           class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-primary/5 hover:border-primary/30 transition-all text-center space-y-2">
                            <div class="w-10 h-10 bg-purple-50 text-purple-500 rounded-lg flex items-center justify-center mx-auto">
                                <span class="material-symbols-outlined">swap_horiz</span>
                            </div>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Who owes who</p>
                        </a>
                        <a href="{{ route('colocations.show', $activeColocation) }}#schedule"
                           class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-primary/5 hover:border-primary/30 transition-all text-center space-y-2">
                            <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-lg flex items-center justify-center mx-auto">
                                <span class="material-symbols-outlined">calendar_month</span>
                            </div>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Cleaning Schedule</p>
                        </a>
                        <a href="{{ route('colocations.show', $activeColocation) }}#grocery"
                           class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-primary/5 hover:border-primary/30 transition-all text-center space-y-2">
                            <div class="w-10 h-10 bg-green-50 text-green-500 rounded-lg flex items-center justify-center mx-auto">
                                <span class="material-symbols-outlined">shopping_basket</span>
                            </div>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">Grocery List</p>
                        </a>
                    </div>
                </div>

            </div>

            {{-- RIGHT 1/3 --}}
            <div class="space-y-6">
                <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-primary/5">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Monthly Overview</h3>
                    <div class="space-y-6">

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-1 rounded-full h-8 bg-primary"></div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Spent</p>
                                    <p class="text-lg font-extrabold text-slate-900 dark:text-white">
                                        {{ number_format((float) ($monthlyExpensesTotal ?? 0), 2, ',', ' ') }} €
                                    </p>
                                </div>
                            </div>
                            <div class="text-[11px] font-bold text-green-500 bg-green-50 px-2 py-1 rounded">+12%</div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-1 rounded-full h-8 bg-purple-500"></div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Your Share</p>
                                    <p class="text-lg font-extrabold text-slate-900 dark:text-white">
                                        {{ number_format((float) ($myShare ?? 0), 2, ',', ' ') }} €
                                    </p>
                                </div>
                            </div>
                            <div class="text-[11px] font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded">Avg</div>
                        </div>

                        <div class="pt-6 border-t border-primary/5">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Top Categories</h4>
                            <div class="space-y-4">
                                <div class="space-y-1.5">
                                    <div class="flex justify-between text-xs font-medium">
                                        <span class="text-slate-600 dark:text-slate-400">Rent & Bills</span>
                                        <span class="text-slate-900 dark:text-white">75%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-primary h-full rounded-full" style="width: 75%"></div>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <div class="flex justify-between text-xs font-medium">
                                        <span class="text-slate-600 dark:text-slate-400">Groceries</span>
                                        <span class="text-slate-900 dark:text-white">15%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-purple-500 h-full rounded-full" style="width: 15%"></div>
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <div class="flex justify-between text-xs font-medium">
                                        <span class="text-slate-600 dark:text-slate-400">Other</span>
                                        <span class="text-slate-900 dark:text-white">10%</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                                        <div class="bg-slate-300 dark:bg-slate-600 h-full rounded-full" style="width: 10%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-primary/5 rounded-xl p-4 border border-primary/10">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-primary text-sm">lightbulb</span>
                                <p class="text-xs font-bold text-primary">Saving Tip</p>
                            </div>
                            <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">
                                Reducing heating by 1°C could save the colocation up to €50 this month!
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        {{-- Recent Expenses Table --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-primary/5">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Recent Expenses</h3>
                <a href="{{ route('colocations.show', $activeColocation) }}" class="text-xs font-bold text-primary hover:underline">View All Expenses</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800">
                            <th class="pb-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="pb-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Description</th>
                            <th class="pb-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Category</th>
                            <th class="pb-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Amount</th>
                            <th class="pb-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Payer</th>
                            <th class="pb-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        @forelse ($recentExpenses ?? [] as $expense)
                            <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="py-4 text-xs font-medium text-slate-500">
                                    {{ $expense->created_at->format('M d, Y') }}
                                </td>
                                <td class="py-4">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $expense->description }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $expense->category ?? '' }}</p>
                                </td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold">
                                        {{ $expense->category ?? 'Other' }}
                                    </span>
                                </td>
                                <td class="py-4 text-right">
                                    <span class="text-sm font-extrabold text-slate-900 dark:text-white">
                                        {{ number_format($expense->amount, 2) }} €
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-primary text-[9px] font-bold">
                                            {{ strtoupper(substr($expense->paidBy?->name ?? '?', 0, 2)) }}
                                        </div>
                                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                                            {{ $expense->paidBy?->name ?? '—' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="py-4 text-right">
                                    @if ($expense->is_settled ?? false)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-50 text-green-600 text-[10px] font-bold">
                                            <span class="w-1 h-1 rounded-full bg-green-500"></span>Paid
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">
                                            <span class="w-1 h-1 rounded-full bg-amber-500"></span>Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-sm text-slate-400">No expenses yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white dark:bg-slate-900 rounded-xl p-6 shadow-sm border border-primary/5">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Recent Activity</h3>
                <a href="{{ route('colocations.show', $activeColocation) }}" class="text-xs font-bold text-primary">View Timeline</a>
            </div>
            <div class="space-y-6">
                @forelse ($recentActivity ?? [] as $activity)
                    <div class="flex gap-4">
                        <div class="h-10 w-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $activity->description }}</p>
                            <p class="text-xs text-slate-500">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="flex gap-4">
                        <div class="h-10 w-10 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Nouvelle dépense ajoutée</p>
                            <p class="text-xs text-slate-500">"Electricity Bill" • {{ number_format(112.40, 2) }} €</p>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 whitespace-nowrap uppercase">2h ago</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="h-10 w-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Paiement effectué</p>
                            <p class="text-xs text-slate-500">"Grocery haul" • {{ number_format(24.50, 2) }} €</p>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 whitespace-nowrap uppercase">5h ago</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="h-10 w-10 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined">emoji_events</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">Monthly Badge Unlocked!</p>
                            <p class="text-xs text-slate-500">"The Master Accountant" - for paying all shares on time.</p>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 whitespace-nowrap uppercase">Yesterday</p>
                    </div>
                @endforelse
            </div>
        </div>

    @else

        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center py-20 bg-white dark:bg-slate-900 rounded-xl border-2 border-dashed border-primary/20 text-center">
            <div class="w-24 h-24 bg-primary/5 rounded-full flex items-center justify-center text-primary mb-6">
                <span class="material-symbols-outlined text-5xl">holiday_village</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2">No active colocation yet!</h2>
            <p class="text-slate-500 max-w-sm mb-8 leading-relaxed">
                It seems you aren't part of a shared space yet. Create your own colocation or join an existing one.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('colocations.index') }}"
                   class="px-6 py-3 bg-primary text-white rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                    Create a Colocation
                </a>
                <a href="{{ route('colocations.index') }}"
                   class="px-6 py-3 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 rounded-lg font-bold text-sm hover:bg-slate-50 transition-colors">
                    Join Existing
                </a>
            </div>
        </div>

    @endif

</x-dashboard-layout>