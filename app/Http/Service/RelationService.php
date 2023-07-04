<?php

namespace App\Http\Service;

use App\Models\Relation;
use Illuminate\Http\Request;

class RelationService {
    public static function currentUserIsConnectedWith(Request $request, $otherUserId) {
        $currentUserId = $request->user()->id;

        $relation1 = Relation::where("creator_id", $currentUserId)
        ->where("target_id", $otherUserId)
        ->where("likes", 1)
        ->first();

        $relation2 = Relation::where("creator_id", $otherUserId)
        ->where("target_id", $currentUserId)
        ->where("likes", 1)
        ->first();

        return !(is_null($relation1) || is_null($relation2));
    }
}