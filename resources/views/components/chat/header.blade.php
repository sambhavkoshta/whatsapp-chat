@props([
'selectedUser'
])

<div class="bg-white border-b p-4">

    <h2 class="text-lg font-semibold">
        {{ $selectedUser->name }}
    </h2>

    <p class="text-sm text-gray-500">
        Offline
    </p>

</div>