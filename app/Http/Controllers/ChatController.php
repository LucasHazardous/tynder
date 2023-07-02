<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
            ->where("target_id", $userId)
            ->where("likes", 1);
        })->whereIn("id", function($query) use ($userId) {
            $query->select("target_id")
            ->from("relations")
            ->where("creator_id", $userId)
            ->where("likes", 1);
        })
        ->get();

        return view("chat", [
            "users" => $users
        ]);
    }

    public function getMessagesWith(Request $request, $connectedUserId): View
    {
        $currentUserId = $request->user()->id;

        $messages = Message::where(function ($query) use ($connectedUserId) {
            $query
            ->where("sender", $connectedUserId)
            ->orWhere("receiver", $connectedUserId);
        })
        ->where(function ($query) use ($currentUserId) {
            $query
            ->where("sender", $currentUserId)
            ->orWhere("receiver", $currentUserId);
        })->orderBy("created_at")->get();

        return view("chat")->with([
            "messages" => $messages,
            "receiver" => $connectedUserId
        ]);
    }

    public function sendMessage(MessageRequest $request): RedirectResponse
    {
        $sender = $request->user()->id;
        $receiver = $request->receiver;

        $relation1 = Relation::where("creator_id", $sender)
        ->where("target_id", $receiver)
        ->where("likes", 1)
        ->first();

        $relation2 = Relation::where("creator_id", $receiver)
        ->where("target_id", $sender)
        ->where("likes", 1)
        ->first();

        if(is_null($relation1) || is_null($relation2)) {
            return abort(403);
        }

        Message::create([
            "sender" => $sender,
            "receiver" => $receiver,
            "content" => $request->content
        ]);

        return back();
    }
}
