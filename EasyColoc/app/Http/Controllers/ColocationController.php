<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreColocationRequest;
use App\Models\Colocation;
use App\Models\User;
use App\Services\SettlementService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ColocationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $activeColocation = $user
            ->activeColocations()
            ->with('owner')
            ->first();

        return view('colocations.index', [
            'activeColocation' => $activeColocation,
        ]);
    }

    public function create(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        if ($user->activeColocations()->exists()) {
            return redirect()
                ->route('colocations.index')
                ->with('error', 'Tu as déjà une colocation active.');
        }

        return view('colocations.create');
    }

    public function store(StoreColocationRequest $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->activeColocations()->exists()) {
            return redirect()
                ->route('colocations.index')
                ->with('error', 'Tu as déjà une colocation active.');
        }

        $colocation = Colocation::create([
            'name' => $request->validated('name'),
            'owner_user_id' => $user->id,
            'status' => 'active',
        ]);

        $colocation->members()->attach($user->id, [
            'role' => 'owner',
            'joined_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation);
    }

    public function show(Request $request, Colocation $colocation, SettlementService $settlementService): View
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);

        $isOwner = ((int) $colocation->owner_user_id === (int) $user->id)
            || (($membership->pivot->role ?? null) === 'owner');

        $month = $request->query('month', 'all');
        $month = is_string($month) ? $month : 'all';

        $start = null;
        $end = null;

        if ($month !== 'all' && preg_match('/^\d{4}-\d{2}$/', $month) === 1) {
            $start = Carbon::createFromFormat('Y-m', $month)->startOfMonth();
            $end = Carbon::createFromFormat('Y-m', $month)->endOfMonth();
        } else {
            $month = 'all';
        }

        $activeMembers = $colocation->activeMembers()->orderBy('name')->get();
        $categories = $colocation->categories()->orderBy('name')->get();

        $expensesQuery = $colocation->expenses()
            ->with(['paidBy', 'category'])
            ->orderByDesc('spent_at');

        if ($start && $end) {
            $expensesQuery->whereBetween('spent_at', [$start->toDateString(), $end->toDateString()]);
        }

        $expenses = $expensesQuery->get();

        $paymentsQuery = $colocation->payments()
            ->with(['fromUser', 'toUser', 'createdBy'])
            ->orderByDesc('paid_at');

        if ($start && $end) {
            $paymentsQuery->whereBetween('paid_at', [$start, $end]);
        }

        $payments = $paymentsQuery->get();

        $months = $colocation->expenses()
            ->orderByDesc('spent_at')
            ->get(['spent_at'])
            ->pluck('spent_at')
            ->map(fn ($d) => $d?->format('Y-m'))
            ->filter()
            ->unique()
            ->values();

        $balances = $settlementService->balances($activeMembers, $expenses, $payments);
        $settlements = $settlementService->settlements($balances);

        return view('colocations.show', [
            'colocation' => $colocation,
            'isOwner' => $isOwner,
            'activeMembers' => $activeMembers,
            'categories' => $categories,
            'expenses' => $expenses,
            'payments' => $payments,
            'month' => $month,
            'months' => $months,
            'balances' => $balances,
            'settlements' => $settlements,
            'formatCents' => fn (int $cents) => $settlementService->formatCents($cents),
        ]);
    }

    public function cancel(Request $request, Colocation $colocation): RedirectResponse
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);
        abort_unless(((int) $colocation->owner_user_id === (int) $user->id) || (($membership->pivot->role ?? null) === 'owner'), 403);

        $colocation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('status', 'Colocation annulée.');
    }

    public function updateMemberRole(Request $request, Colocation $colocation, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'in:owner,member'],
        ]);

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 404);

        $role = $request->input('role');

        if ($role === 'owner') {
            $currentOwnerIds = $colocation->members()
                ->wherePivot('role', 'owner')
                ->pluck('id');
            foreach ($currentOwnerIds as $uid) {
                $colocation->members()->updateExistingPivot($uid, ['role' => 'member']);
            }
            $colocation->members()->updateExistingPivot($user->id, ['role' => 'owner']);
            $colocation->update(['owner_user_id' => $user->id]);
        } else {
            $colocation->members()->updateExistingPivot($user->id, ['role' => 'member']);
        }

        return back()->with('status', 'Rôle mis à jour.');
    }
}
