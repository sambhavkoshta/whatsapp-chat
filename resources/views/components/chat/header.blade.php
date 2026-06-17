@props([
'selectedUser'
])

<div class="bg-white border-b p-4">

    <h2 class="text-lg font-semibold">
        {{ $selectedUser->name }}
    </h2>

    <p id="user-status"
        class="text-sm text-gray-500"
        data-last-seen="{{ $selectedUser->last_seen_at?->format('h:i A') }}">

        @if($selectedUser->last_seen_at)
        Last seen {{ $selectedUser->last_seen_at->format('h:i A') }}
        @endif

    </p>
    <p
        id="typing-indicator"
        class="text-sm text-green-500">
    </p>

</div>