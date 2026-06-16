<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\User;

class ChatService
{
    public function findOrCreateConversation(User $user1, User $user2)
    {
        $conversation = $user1->conversations()
            ->whereHas('users', function ($query) use ($user2) {
                $query->where('users.id', $user2->id);
            })
            ->first();

        if (!$conversation) {

            $conversation = Conversation::create();

            $conversation->users()->attach([
                $user1->id,
                $user2->id
            ]);
        }

        return $conversation;
    }

    public function getUserConversations()
    {
        return auth()->user()
            ->conversations()
            ->with([
                'users',
                'latestMessage'
            ])
            ->withMax('messages', 'created_at')
            ->orderByDesc('messages_max_created_at')
            ->get();
    }
}
