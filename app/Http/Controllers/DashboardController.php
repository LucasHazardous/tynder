<?php

namespace App\Http\Controllers;

use App\Http\Requests\RelationRequest;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    public function createRelation(RelationRequest $request): RedirectResponse
    {
        $potentialRelation = Relation::where("creator_id", $request->user()->id)->where("target_id", $request->target_id)->first();
        
        if(!is_null($potentialRelation)) {
            return abort(403);
        }

        Relation::create([
            "creator_id" => $request->user()->id,
            "target_id" => $request->target_id,
            "likes" => intval($request->likes),
        ]);

        return back();
    }
}
