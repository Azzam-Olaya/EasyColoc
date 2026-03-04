<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColocationController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    $user = $request->user();
    $activeColocation = $user->activeColocations()->with('owner')->first();
    $monthlyExpensesTotal = $activeColocation
        ? $activeColocation->expenses()->whereMonth('spent_at', now()->month)->whereYear('spent_at', now()->year)->sum('amount')
        : 0;
    $activeMembersCount = $activeColocation ? $activeColocation->activeMembers()->count() : 0;
    return view('dashboard', [
        'activeColocation' => $activeColocation,
        'monthlyExpensesTotal' => $monthlyExpensesTotal,
        'activeMembersCount' => $activeMembersCount,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');
    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');
    Route::post('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');

    Route::post('/colocations/{colocation}/invitations', [InvitationController::class, 'store'])->name('invitations.store');
    Route::get('/invitations/{token}', [InvitationController::class, 'show'])->name('invitations.show');
    Route::post('/invitations/{token}/accept', [InvitationController::class, 'accept'])->name('invitations.accept');
    Route::post('/invitations/{token}/decline', [InvitationController::class, 'decline'])->name('invitations.decline');

    Route::post('/colocations/{colocation}/members/{user}/remove', [ColocationController::class, 'removeMember'])->name('colocations.members.remove');
    Route::post('/colocations/{colocation}/leave', [ColocationController::class, 'leave'])->name('colocations.leave');

    Route::post('/colocations/{colocation}/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::post('/colocations/{colocation}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::post('/colocations/{colocation}/payments', [PaymentController::class, 'store'])->name('payments.store');

    Route::middleware('global_admin')->group(function () {
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users.index');
        Route::post('/admin/users/{user}/ban', [AdminController::class, 'ban'])->name('admin.users.ban');
        Route::post('/admin/users/{user}/unban', [AdminController::class, 'unban'])->name('admin.users.unban');
        Route::post('/admin/colocations/{colocation}/users/{user}/role', [ColocationController::class, 'updateMemberRole'])->name('admin.colocations.users.role');
    });
});

require __DIR__.'/auth.php';
