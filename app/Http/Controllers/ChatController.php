<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function getConnectedUsers(Request $request): View
    {
        $userId = $request->user()->id;
        $users = User::whereIn("id", function($query) use ($userId) {
            $query->select("creator_id")
            ->from("relations")
            ->where("target_id", $userId);
        })->whereIn("id", function($query) use ($userId) {
            $query->select("target_id")
            ->from("relations")
            ->where("creator_id", $userId);
        })
        ->get();

        return view("chat", [
            "users" => $users
        ]);
    }
}
