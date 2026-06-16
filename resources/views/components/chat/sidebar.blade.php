 <div class="w-1/4 bg-white border-r">

     <div class="p-4 border-b">
         <h2 class="text-xl font-bold">
             Chats
         </h2>
     </div>

     <div>

         @foreach ($conversations as $chat)

         @php
         $otherUser = $chat->users->firstWhere('id', '!=', auth()->id());
         @endphp

         <a
             href="{{ route('chat.show', $otherUser) }}"
             class="flex items-center gap-3 p-4 border-b hover:bg-gray-100
                    {{ isset($conversation) && $chat->id == $conversation->id ? 'bg-gray-200' : '' }}">

             <!-- Avatar -->
             <div
                 class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-bold">

                 {{ strtoupper(substr($otherUser->name, 0, 1)) }}

             </div>

             <div class="flex-1">

                 <!-- User Name -->
                 <h3 class="font-medium">
                     {{ $otherUser->name }}
                 </h3>

                 <!-- Latest Message -->
                 <div class="flex justify-between items-center">

                     <p class="text-sm text-gray-500 truncate">
                         {{ $chat->latestMessage?->body }}
                     </p>

                     @if($chat->latestMessage)
                     <span class="text-xs text-gray-400 ml-2">
                         {{ $chat->latestMessage->created_at->format('h:i A') }}
                     </span>
                     @endif

                 </div>

             </div>

         </a>

         @endforeach

     </div>

 </div>