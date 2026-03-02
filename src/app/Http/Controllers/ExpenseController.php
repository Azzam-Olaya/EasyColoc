<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpenseRequest;
use App\Models\Colocation;
use App\Models\Expense;
use Illuminate\Http\RedirectResponse;

class ExpenseController extends Controller
{
    public function store(StoreExpenseRequest $request, Colocation $colocation): RedirectResponse
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);

        $paidByUserId = (int) $request->validated('paid_by_user_id');

        $isPayerActiveMember = $colocation->activeMembers()
            ->whereKey($paidByUserId)
            ->exists();

        abort_unless($isPayerActiveMember, 422);

        $categoryId = $request->validated('category_id');
        if ($categoryId !== null) {
            $belongs = $colocation->categories()->whereKey($categoryId)->exists();
            abort_unless($belongs, 422);
        }

        Expense::create([
            'colocation_id' => $colocation->id,
            'paid_by_user_id' => $paidByUserId,
            'category_id' => $categoryId,
            'title' => $request->validated('title'),
            'amount' => $request->validated('amount'),
            'spent_at' => $request->validated('spent_at'),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('status', 'Dépense ajoutée.');
    }
}
