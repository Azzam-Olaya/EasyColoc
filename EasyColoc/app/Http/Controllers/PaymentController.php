<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Models\Colocation;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function store(StorePaymentRequest $request, Colocation $colocation): RedirectResponse
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);

        $fromUserId = (int) $user->id;
        $toUserId = (int) $request->validated('to_user_id');

        abort_unless($fromUserId !== $toUserId, 422);

        $isToActiveMember = $colocation->activeMembers()
            ->whereKey($toUserId)
            ->exists();

        abort_unless($isToActiveMember, 422);

        Payment::create([
            'colocation_id' => $colocation->id,
            'from_user_id' => $fromUserId,
            'to_user_id' => $toUserId,
            'created_by_user_id' => $user->id,
            'amount' => $request->validated('amount'),
            'paid_at' => $request->validated('paid_at') ?? now(),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('status', 'Paiement enregistré.');
    }
}
