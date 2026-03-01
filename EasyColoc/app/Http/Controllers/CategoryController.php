<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function store(StoreCategoryRequest $request, Colocation $colocation): RedirectResponse
    {
        $user = $request->user();

        $membership = $colocation->members()
            ->whereKey($user->id)
            ->wherePivotNull('left_at')
            ->first();

        abort_unless($membership, 403);
        abort_unless(((int) $colocation->owner_user_id === (int) $user->id) || (($membership->pivot->role ?? null) === 'owner'), 403);

        Category::create([
            'colocation_id' => $colocation->id,
            'name' => $request->validated('name'),
        ]);

        return redirect()->route('colocations.show', $colocation)->with('status', 'Catégorie ajoutée.');
    }
}
