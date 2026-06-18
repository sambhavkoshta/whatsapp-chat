<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ChatService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(
        protected ChatService $chatService
    ) {}

    public function create()
    {
        $users = User::where(
            'id',
            '!=',
            auth()->id()
        )->get();

        return view(
            'chat.groups.create',
            compact('users')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'users' => ['required', 'array'],
        ]);

        $conversation =
            $this->chatService
            ->createGroupConversation(
                $request->name,
                $request->users
            );

        return redirect()->route(
            'chat.show',
            $conversation->users()
                ->where(
                    'users.id',
                    '!=',
                    auth()->id()
                )
                ->first()
        );
    }
}
