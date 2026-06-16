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

                <div class="flex items-center gap-3 p-4 border-b hover:bg-gray-100 cursor-pointer">

                    <!-- Avatar -->
                    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <!-- Name -->
                    <div>
                        <h3 class="font-medium">
                            {{ $user->name }}
                        </h3>
                    </div>

                </div>

                @endforeach

            </div>

        </div>

        <!-- Chat Window -->
        <div class="flex-1 flex items-center justify-center">

            <div class="text-center text-gray-500">

                <h2 class="text-2xl font-semibold mb-2">
                    WhatsApp Chat
                </h2>

                <p>
                    Select a conversation to start chatting
                </p>

            </div>

        </div>

    </div>

</x-app-layout>