<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'body' => ['required']
        ]);

        $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $request->body
        ]);

        $otherUser = $conversation
            ->users()
            ->where('users.id', '!=', auth()->id())
            ->first();

        return redirect()->route('chat.show', $otherUser);
    }
}
