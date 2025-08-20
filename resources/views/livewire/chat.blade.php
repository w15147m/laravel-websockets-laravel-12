<div>

    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1" class="mb-4">{{ __('Chat') }}</flux:heading>
        {{-- <flux:subheading size="lg" class="mb-6">{{ __('Manage your friends') }}</flux:subheading> --}}
        <flux:separator variant="subtle" />
    </div>
    <div
        class="flex h-[700px] text-sm border rounded-xl shadow-lg overflow-hidden bg-white dark:bg-gray-900 dark:border-gray-700">
        <!-- Sidebar -->
        <div class="w-1/4 border-r bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-4">
                <h1 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3 p-4">
                    {{ $user->name }}</h1>
                <hr class="border-gray-200 dark:border-gray-600 mb-4">
                <!-- Users -->
                @foreach ($users as $item)
                    <div wire:click="selectUser({{ $item->id }})"
                        class="flex items-center gap-3 p-3 mb-2 rounded-xl cursor-pointer transition{{ $selectedUser && $selectedUser->id === $item->id ? 'bg-indigo-100 dark:bg-gray-700 border border-indigo-400 shadow-md' : 'hover:bg-gray-200 dark:hover:bg-gray-700' }}">
                        <div class="relative">
                            <div
                                class="h-10 w-10 flex-shrink-0 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($item->name, 0, 2)) }}
                            </div>
                            <span
                                class="absolute bottom-0 right-0 block w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></span>
                        </div>

                        <div class="text-wrap">
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                                {{ $item->name }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 w-36 break-words">
                                <span>{{ $item->email }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <!-- Chat Section -->
        <div class="w-3/4 flex flex-col">
            <!-- Header -->

            <div
                class="flex items-center justify-between p-4 border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div
                        class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($selectedUser->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="text-lg font-semibold text-gray-800 dark:text-gray-200"> {{ $selectedUser->name }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Offline</div>
                    </div>
                </div>

            </div>

            <!-- Messages -->
            <div class="flex-1 p-4 overflow-y-auto space-y-4 bg-gray-100 dark:bg-gray-900">
                <!-- Messages -->
                <div class="flex-1  p-4 overflow-y-auto space-y-4 bg-gray-100 dark:bg-gray-900">
                    @foreach ($messages as $message)
                        @if ($message->sender_id === $user->id)
                            <div class="flex justify-end">
                                <div
                                    class="max-w-xs px-4 py-2 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow">
                                    {{ $message->message }}
                                    <div class="text-[10px] text-right opacity-70 mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </div>
                                <div
                                    class="h-10 m-2 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($selectedUser->name, 0, 2)) }}
                                </div>
                            </div>
                        @else
                            <!-- Received -->
                            <div class="flex justify-start">
                                <div
                                    class="h-10 m-2 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div
                                    class="max-w-xs px-4 py-2 rounded-2xl bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow border dark:border-gray-600">
                                    {{ $message->message }}
                                    <div class="text-[10px] text-left text-gray-400 mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>


            </div>

            <!-- Input -->
            <form wire:submit.prevent="submit"
                class="p-4 border-t bg-white dark:bg-gray-900 dark:border-gray-700 flex items-center gap-2">
                <input type="text" wire:model="newMessage"
                    class="flex-1 border border-gray-300 dark:border-gray-600 rounded-full px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 shadow-sm"
                    placeholder="Type your message..." />
                <button type="submit"
                    class="px-5 py-2 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-medium shadow hover:opacity-90 transition">
                    Send
                </button>
            </form>
        </div>
    </div>

</div>
