@props([
'conversation'
])

<div class="bg-white p-4 border-t">

    <form
        action="{{ route('messages.store', $conversation) }}"
        method="POST"
        class="flex gap-3">
        @csrf

        <input
            type="text"
            name="body"
            required
            autocomplete="off"
            placeholder="Type a message..."
            class="flex-1 border rounded-lg px-4 py-2">

        <button
            class="bg-green-500 text-white px-6 py-2 rounded-lg">
            Send
        </button>

    </form>

</div>