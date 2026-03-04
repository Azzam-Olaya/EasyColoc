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
use Illuminate\Support\Facades\DB;

class ColocationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $activeColocation = $user
            ->activeColocations()
            ->with('owner')
            ->first();

        $allColocations = null;
        if ($user->is_global_admin) {
            $allColocations = Colocation::query()
                ->with(['owner'])
                ->withCount('activeMembers')
                ->orderByDesc('created_at')
                ->paginate(15, ['*'], 'colocations_page');
        }

        return view('colocations.index', [
            'activeColocation' => $activeColocation,
            'allColocations' => $allColocations,
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
        /* echo "ana hnaaaaaaaaaaaaaaaaaaaaaaaaaa      "; */

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

    public function cancel(Request $request, Colocation $colocation, SettlementService $settlementService): RedirectResponse
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);
        abort_unless(((int) $colocation->owner_user_id === (int) $user->id) || (($membership->pivot->role ?? null) === 'owner'), 403);

        $activeMembers = $colocation->activeMembers()->get();
        $expenses = $colocation->expenses()->get();
        $payments = $colocation->payments()->get();
        
        $balances = $settlementService->balances($activeMembers, $expenses, $payments);

        foreach ($balances as $balance) {
            $member = $balance['user'];
            if ($balance['balance_cents'] < 0) {
                $member->decrement('reputation_score');
            } else {
                $member->increment('reputation_score');
            }
        }

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

    public function leave(Request $request, Colocation $colocation, SettlementService $settlementService): RedirectResponse
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);

        $isOwner = ((int) $colocation->owner_user_id === (int) $user->id)
            || (($membership->pivot->role ?? null) === 'owner');
        
        if ($isOwner) {
            return back()->with('error', 'En tant que Owner, tu ne peux pas quitter directement. Transfère ton rôle ou annule la colocation.');
        }

        DB::transaction(function () use ($colocation, $user, $settlementService) {
            $this->processDeparture($colocation, $user, false, $settlementService);
        });

        return redirect()->route('dashboard')->with('status', 'Tu as quitté la colocation.');
    }

    public function removeMember(Request $request, Colocation $colocation, User $user, SettlementService $settlementService): RedirectResponse
    {
        $currentUser = $request->user();

        $currentMembership = $colocation->members()
            ->whereKey($currentUser->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($currentMembership, 403);
        $isOwner = ((int) $colocation->owner_user_id === (int) $currentUser->id)
            || (($currentMembership->pivot->role ?? null) === 'owner');
        abort_unless($isOwner, 403);

        $targetMembership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();
            
        abort_unless($targetMembership, 404);

        $isTargetOwner = ((int) $colocation->owner_user_id === (int) $user->id)
            || (($targetMembership->pivot->role ?? null) === 'owner');

        if ($isTargetOwner) {
            return back()->with('error', 'Tu ne peux pas retirer un Owner.');
        }

        DB::transaction(function () use ($colocation, $user, $settlementService) {
            $this->processDeparture($colocation, $user, true, $settlementService);
        });

        return back()->with('status', 'Membre retiré avec succès.');
    }

    private function processDeparture(Colocation $colocation, User $leavingUser, bool $isRemoval, SettlementService $settlementService)
    {
        $activeMembers = $colocation->activeMembers()->get();
        $ownerId = $colocation->owner_user_id;

        $expenses = $colocation->expenses()->get();
        $payments = $colocation->payments()->get();
        $oldBalances = $settlementService->balances($activeMembers, $expenses, $payments);

        $leavingUserOldBalance = collect($oldBalances)->firstWhere('user.id', $leavingUser->id);

        if ($leavingUserOldBalance) {
            if ($leavingUserOldBalance['balance_cents'] < 0) {
                $leavingUser->decrement('reputation_score');
            } else {
                $leavingUser->increment('reputation_score');
            }
        }

        $colocation->members()->updateExistingPivot($leavingUser->id, ['left_at' => now()]);

        $colocation->expenses()->where('paid_by_user_id', $leavingUser->id)->update(['paid_by_user_id' => $ownerId]);
        $colocation->payments()->where('from_user_id', $leavingUser->id)->update(['from_user_id' => $ownerId]);
        $colocation->payments()->where('to_user_id', $leavingUser->id)->update(['to_user_id' => $ownerId]);

        if ($isRemoval) {
            $newActiveMembers = $colocation->activeMembers()->get();
            $newExpenses = $colocation->expenses()->get();
            $newPayments = $colocation->payments()->get();
            $newBalances = $settlementService->balances($newActiveMembers, $newExpenses, $newPayments);

            foreach ($newActiveMembers as $member) {
                if ($member->id === $ownerId) continue;

                $oldBal = collect($oldBalances)->firstWhere('user.id', $member->id)['balance_cents'] ?? 0;
                $newBal = collect($newBalances)->firstWhere('user.id', $member->id)['balance_cents'] ?? 0;
                
                $diff = $newBal - $oldBal;

                if ($diff < 0) {
                    \App\Models\Payment::create([
                        'colocation_id' => $colocation->id,
                        'from_user_id' => $ownerId,
                        'to_user_id' => $member->id,
                        'created_by_user_id' => $ownerId,
                        'amount' => number_format(abs($diff) / 100, 2, '.', ''),
                        'paid_at' => now(),
                    ]);
                } elseif ($diff > 0) {
                    \App\Models\Payment::create([
                        'colocation_id' => $colocation->id,
                        'from_user_id' => $member->id,
                        'to_user_id' => $ownerId,
                        'created_by_user_id' => $ownerId,
                        'amount' => number_format(abs($diff) / 100, 2, '.', ''),
                        'paid_at' => now(),
                    ]);
                }
            }
        }
    }
}
