<x-app-layout>

    <div class="max-w-2xl mx-auto py-8">

        <div class="bg-white rounded-xl shadow p-6">

            <h1 class="text-2xl font-bold mb-6">
                Create New Group
            </h1>

            <form
                action="{{ route('groups.store') }}"
                method="POST"
                class="space-y-6">

                @csrf

                <!-- Group Name -->
                <div>

                    <label class="block font-medium mb-2">
                        Group Name
                    </label>

                    <input
                        type="text"
                        name="name"
                        required
                        class="w-full border rounded-lg px-4 py-2"
                        placeholder="Laravel Developers">

                </div>

                <!-- Members -->
                <div>

                    <label class="block font-medium mb-3">
                        Select Members
                    </label>

                    <div class="space-y-3">

                        @foreach ($users as $user)

                        <label
                            class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                name="users[]"
                                value="{{ $user->id }}">

                            <span>
                                {{ $user->name }}
                            </span>

                        </label>

                        @endforeach

                    </div>

                </div>

                <!-- Submit -->
                <button
                    class="bg-green-500 text-white px-6 py-2 rounded-lg">

                    Create Group

                </button>

            </form>

        </div>

    </div>

</x-app-layout>