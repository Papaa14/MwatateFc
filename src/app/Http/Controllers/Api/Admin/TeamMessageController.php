<?php

namespace App\Http\Controllers\Api\Admin;
use App\Http\Controllers\Controller;
use App\Models\TeamMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamMessageController extends Controller
{
    public function index() {
        return response()->json(['data' => TeamMessage::latest()->get()]);
    }

    public function store(Request $request) {
        $request->validate(['recipient' => 'required', 'subject' => 'required', 'content' => 'required']);

        $msg = TeamMessage::create([
            'sender_id' => Auth::id(),
            'recipient_group' => $request->recipient,
            'subject' => $request->subject,
            'content' => $request->content
        ]);
        return response()->json(['message' => 'Message sent', 'data' => $msg]);
    }
}
