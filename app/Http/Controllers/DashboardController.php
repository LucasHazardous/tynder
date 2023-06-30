<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function recommend(Request $request): View
    {
        $userId = $request->user()->id;

        $userWithoutRelation = User::whereNotIn('id', function ($query) use ($userId) {
            $query->select('target_id')
                ->from('relations')
                ->where('creator_id', $userId);
        })
        ->where('id', '!=', $userId)
        ->first();

        return view('dashboard.dashboard', [
            'user' => $userWithoutRelation,
        ]);
    }
}
