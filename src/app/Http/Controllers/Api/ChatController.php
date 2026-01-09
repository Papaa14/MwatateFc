<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TeamMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Get messages for current user (sender or receiver)
    public function index()
    {
        $userId = Auth::id();

        $messages = TeamMessage::where(function ($query) use ($userId) {
            $query->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
        })
        ->with(['sender', 'receiver'])
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json(['data' => $messages]);
    }

    // Send message (individual or group)
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'receiver_id' => 'sometimes|exists:users,id', // For individual messages
            'recipient_group' => 'sometimes|in:all,squad,reserves' // For group messages
        ]);

        // Must have either receiver_id OR recipient_group
        if (!$request->filled('receiver_id') && !$request->filled('recipient_group')) {
            return response()->json(
                ['message' => 'Either receiver_id or recipient_group is required'],
                422
            );
        }
        $data = $request->input('content');

        $messageData = [
            'sender_id' => Auth::id(),
            'content' => $data,
            'is_read' => false
        ];

        // Individual message
        if ($request->filled('receiver_id')) {
            $messageData['receiver_id'] = $request->receiver_id;
            $messageData['recipient_group'] = null;
        }

        // Group message
        if ($request->filled('recipient_group')) {
            $messageData['recipient_group'] = $request->recipient_group;
            $messageData['receiver_id'] = null;
        }

        $message = TeamMessage::create($messageData);

        return response()->json([
            'data' => $message->load('sender', 'receiver'),
            'message' => 'Message sent successfully'
        ], 201);
    }
}
