<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationRequest;
use App\Models\Colocation;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function store(StoreInvitationRequest $request, Colocation $colocation): RedirectResponse
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);
        abort_unless(((int) $colocation->owner_user_id === (int) $user->id) || (($membership->pivot->role ?? null) === 'owner'), 403);

        $invitation = Invitation::create([
            'colocation_id' => $colocation->id,
            'invited_by_user_id' => $user->id,
            'email' => strtolower($request->validated('email')),
            'token' => Str::random(40),
            'status' => 'pending',
            'expires_at' => now()->addDays(7),
        ]);

        return redirect()
            ->route('colocations.show', $colocation)
            ->with('status', 'Invitation créée. Lien: '.route('invitations.show', $invitation->token));
    }

    public function show(Request $request, string $token): View
    {
        $invitation = Invitation::query()
            ->where('token', $token)
            ->firstOrFail();

        return view('invitations.show', [
            'invitation' => $invitation,
        ]);
    }

    public function accept(Request $request, string $token): RedirectResponse
    {
        $user = $request->user();

        $invitation = Invitation::query()
            ->where('token', $token)
            ->firstOrFail();

        if ($invitation->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', "Cette invitation n'est plus valide.");
        }

        if ($invitation->expires_at && $invitation->expires_at->isPast()) {
            return redirect()->route('dashboard')->with('error', "Cette invitation a expiré.");
        }

        if (strtolower($user->email) !== strtolower($invitation->email)) {
            return redirect()->route('dashboard')->with('error', "Ton email ne correspond pas à l'invitation.");
        }

        if ($user->activeColocations()->exists()) {
            return redirect()->route('dashboard')->with('error', 'Tu as déjà une colocation active.');
        }

        $colocation = $invitation->colocation()->firstOrFail();

        $colocation->members()->attach($user->id, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        $invitation->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('status', 'Invitation acceptée.');
    }

    public function decline(Request $request, string $token): RedirectResponse
    {
        $invitation = Invitation::query()
            ->where('token', $token)
            ->firstOrFail();

        if ($invitation->status !== 'pending') {
            return redirect()->route('dashboard');
        }

        $invitation->update([
            'status' => 'declined',
            'responded_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('status', 'Invitation refusée.');
    }
}
