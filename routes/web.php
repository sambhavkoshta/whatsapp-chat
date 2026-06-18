<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\MessageController;
use App\Http\Controllers\Chat\GroupController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [ChatController::class, 'show'])->name('chat.show');

    Route::post('/conversations/{conversation}/messages',[MessageController::class, 'store'])->name('messages.store');

    Route::get('/groups/create',[GroupController::class, 'create'])->name('groups.create');

    Route::post('/groups',[GroupController::class, 'store'])->name('groups.store');

    Route::get('/conversations/{conversation}',[ChatController::class, 'showConversation'])->name('conversations.show');
});

require __DIR__.'/auth.php';
