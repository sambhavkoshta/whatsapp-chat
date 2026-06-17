<?php

use App\Models\Conversation;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {

    return Conversation::findOrFail($conversationId)
        ->users()
        ->where('users.id', $user->id)
        ->exists();
});

Broadcast::channel('presence.conversation.{conversationId}', function ($user, $conversationId) {

    if (
        Conversation::findOrFail($conversationId)
        ->users()
        ->where('users.id', $user->id)
        ->exists()
    ) {
        return [
            'id' => $user->id,
            'name' => $user->name,
        ];
    }
});