<x-app-layout>

    <div class="flex h-[calc(100vh-65px)] bg-gray-100">

        <!-- Sidebar -->
        <div class="w-1/4 bg-white border-r">

            <div class="p-4 border-b">
                <h2 class="text-xl font-bold">
                    Chats
                </h2>
            </div>

            <div>

                @foreach ($users as $user)

                <a href="{{ route('chat.show', $user) }}"
                    class="flex items-center gap-3 p-4 border-b hover:bg-gray-100">

                    <!-- Avatar -->
                    <div
                        class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <!-- Name -->
                    <div>
                        <h3 class="font-medium">
                            {{ $user->name }}
                        </h3>
                    </div>

                </a>

                @endforeach

            </div>

        </div>

        <!-- Chat Window -->
        <div class="flex-1">

            @isset($selectedUser)

            <!-- Header -->
            <div class="bg-white border-b p-4">
                <h2 class="text-lg font-semibold">
                    {{ $selectedUser->name }}
                </h2>
            </div>

            <!-- Messages Area -->
            <div class="h-[75vh] overflow-y-auto p-4 space-y-4 bg-gray-100">

                @forelse ($messages as $message)

                <div class="flex {{ $message->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

                    <div class="
                        max-w-sm px-4 py-2 rounded-lg shadow
                        {{ $message->user_id == auth()->id()
                            ? 'bg-green-500 text-white'
                            : 'bg-white'
                        }}
                    ">

                        <p>
                            {{ $message->body }}
                        </p>

                        <div class="text-xs mt-1 opacity-70">
                            {{ $message->created_at->format('h:i A') }}
                        </div>

                    </div>

                </div>

                @empty

                <div class="flex items-center justify-center h-full text-gray-500">
                    No messages yet
                </div>

                @endforelse

            </div>

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

            @else

            <div class="h-full flex items-center justify-center">

                <div class="text-center text-gray-500">

                    <h2 class="text-2xl font-semibold mb-2">
                        WhatsApp Chat
                    </h2>

                    <p>
                        Select a conversation to start chatting
                    </p>

                </div>

            </div>

            @endisset


        </div>

    </div>

</x-app-layout>