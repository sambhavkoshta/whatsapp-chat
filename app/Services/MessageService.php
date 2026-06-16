<?php

namespace App\Services;

use App\Models\Conversation;

class MessageService
{
    public function sendMessage(Conversation $conversation, string $body)
    {
        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $body
        ]);

        return $message;
    }
}
