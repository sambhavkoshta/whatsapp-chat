<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ChatService;
use App\Models\Conversation;

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
        $selectedUser = User::findOrFail($user->id);
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
            'selectedUser' => $selectedUser,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }

    public function showConversation(
        Conversation $conversation
    ) {
        abort_unless(
            $conversation
                ->users()
                ->where('users.id', auth()->id())
                ->exists(),
            403
        );

        $conversations = $this->chatService
            ->getUserConversations();

        $messages = $conversation
            ->messages()
            ->with('user')
            ->oldest()
            ->get();

        return view('chat.index', [
            'conversations' => $conversations,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }
}
