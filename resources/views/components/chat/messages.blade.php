@props([
'messages',
'conversation'
])
<!-- Messages Area -->
<div id="messages" class="h-[75vh] overflow-y-auto p-4 space-y-4 bg-gray-100">

    @forelse ($messages as $message)

    <div class="flex {{ $message->user_id == auth()->id() ? 'justify-end' : 'justify-start' }}">

        <div class="
                        max-w-sm px-4 py-2 rounded-lg shadow
                        {{ $message->user_id == auth()->id()
                            ? 'bg-green-500 text-white'
                            : 'bg-white'
                        }}
                    ">
            @if(
            $conversation->isGroup()
            && $message->user_id != auth()->id()
            )

            <div class="text-xs font-semibold text-green-600 mb-1">

                {{ $message->user->name }}

            </div>

            @endif

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

        Start a conversation 👋

    </div>

    @endforelse

</div>