<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        $stats = [
            'users' => User::query()->count(),
            'banned_users' => User::query()->where('is_banned', true)->count(),
            'colocations' => Colocation::query()->count(),
            'expenses' => Expense::query()->count(),
        ];

        $users = User::query()
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.dashboard', [
            'stats' => $stats,
            'users' => $users,
        ]);
    }

    public function ban(Request $request, User $user): RedirectResponse
    {
        if ((int) $request->user()->id === (int) $user->id) {
            return back()->with('error', "Tu ne peux pas te bannir toi-même.");
        }

        $user->update([
            'is_banned' => true,
            'banned_at' => now(),
        ]);

        return back()->with('status', "Utilisateur banni.");
    }

    public function unban(Request $request, User $user): RedirectResponse
    {
        $user->update([
            'is_banned' => false,
            'banned_at' => null,
        ]);

        return back()->with('status', "Utilisateur débanni.");
    }
}
