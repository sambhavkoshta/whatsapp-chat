@props([
'conversation'
])

@php

if ($conversation->isGroup()) {

$title = $conversation->name;

} else {

$otherUser = $conversation
->users
->firstWhere(
'id',
'!=',
auth()->id()
);

$title = $otherUser->name;
}

@endphp

<div class="bg-white border-b p-4">

    <h2 class="text-lg font-semibold">
        {{ $title }}
    </h2>

    <p id="user-status"
        class="text-sm text-gray-500"

        @unless($conversation->isGroup())
        data-last-seen="{{ $otherUser->last_seen_at?->format('h:i A') }}"
        @endunless
        >

        @if(!$conversation->isGroup())

        @if($otherUser->last_seen_at)

        Last seen {{ $otherUser->last_seen_at->format('h:i A') }}

        @endif

        @endif

    </p>
    <p
        id="typing-indicator"
        class="text-sm text-green-500">
    </p>

    @if($conversation->isGroup())

    <p class="text-sm text-gray-500">

        {{ $conversation->users->count() }}
        participants

    </p>

    @endif

</div>