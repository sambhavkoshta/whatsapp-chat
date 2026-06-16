<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ChatService;

class ChatController extends Controller
{
    //
    public function __construct(
        protected ChatService $chatService
    ) {}

    public function index()
    {
        $conversations = $this->chatService
            ->getUserConversations();

        return view('chat.index', [
            'conversations' => $conversations,
            'selectedUser' => null,
            'conversation' => null,
            'messages' => collect(),
        ]);
    }

    public function show(User $user)
    {
        $conversations = $this->chatService
            ->getUserConversations();

        $conversation = $this->chatService
            ->findOrCreateConversation(auth()->user(), $user);

        $messages = $conversation
            ->messages()
            ->with('user')
            ->oldest()
            ->get();

        return view('chat.index', [
            'conversations' => $conversations,
            'selectedUser' => $user,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }
}
