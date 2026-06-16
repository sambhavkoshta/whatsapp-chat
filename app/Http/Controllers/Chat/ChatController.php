<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //
    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return view('chat.index', compact('users'));
    }
}
