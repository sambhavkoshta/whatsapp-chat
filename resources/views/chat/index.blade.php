<x-app-layout>

    <div class="flex h-[calc(100vh-65px)] bg-gray-100">

        <x-chat.sidebar
            :conversations="$conversations"
            :conversation="$conversation" />

        <div class="flex-1">

            @isset($selectedUser)

            <input
                type="hidden"
                id="conversation-id"
                value="{{ $conversation->id }}">

            <input
                type="hidden"
                id="current-user-id"
                value="{{ auth()->id() }}">

            <input
                type="hidden"
                id="current-user-name"
                value="{{ auth()->user()->name }}">
                
            <x-chat.header
                :selected-user="$selectedUser" />

            <x-chat.messages
                :messages="$messages" />

            <x-chat.input
                :conversation="$conversation" />

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