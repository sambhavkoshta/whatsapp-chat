<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMessageRequest;
use App\Services\MessageService;
use App\Events\MessageSent;

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

        $message = $this->messageService->sendMessage(
            $conversation,
            $request->body
        );

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'id' => $message->id,
            'body' => $message->body,
            'user_id' => $message->user_id,
            'created_at' => $message->created_at->format('h:i A'),
        ]);
    }
}
