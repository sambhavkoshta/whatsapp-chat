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
        $users = User::where('id', '!=', auth()->id())->get();

        return view('chat.index', compact('users'));
    }

    public function show(User $user)
    {
        $users = User::where('id', '!=', auth()->id())->get();

        $conversation = $this->chatService
            ->findOrCreateConversation(auth()->user(), $user);

        $messages = $conversation
            ->messages()
            ->with('user')
            ->oldest()
            ->get();

        return view('chat.index', [
            'users' => $users,
            'selectedUser' => $user,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
    }
}
