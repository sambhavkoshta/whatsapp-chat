<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageRequest;
use App\Services\MessageService;

class MessageController extends Controller
{
    public function __construct(
        protected MessageService $messageService
    ) {}

    public function store(
        StoreMessageRequest $request,
        Conversation $conversation
    ) {
        abort_unless(
            $conversation
                ->users()
                ->where('users.id', auth()->id())
                ->exists(),
            403
        );

        $this->messageService->sendMessage(
            $conversation,
            $request->body
        );

        $otherUser = $conversation
            ->users()
            ->where('users.id', '!=', auth()->id())
            ->first();

        return redirect()->route('chat.show', $otherUser);
    }
}
