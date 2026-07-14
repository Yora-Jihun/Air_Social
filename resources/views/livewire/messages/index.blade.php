<div>
    <x-topbar :notification-count="3" :user-name="auth()->user()->name" />

    <div class="mx-auto max-w-6xl px-4 py-6">
        <div class="grid grid-cols-1 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 h-[calc(100dvh-7rem)] lg:grid-cols-[320px_minmax(0,1fr)]">

            {{-- Conversation list --}}
            <div class="flex flex-col border-gray-200 lg:flex lg:flex-col lg:border-r {{ $activeConversation ? 'max-lg:hidden' : '' }}">
                <div class="border-b border-gray-200 px-4 py-3">
                    <h2 class="text-base font-bold text-gray-900">Messages</h2>
                    <div class="relative mt-3">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                            <x-icon name="search" class="h-4 w-4" />
                        </span>
                        <input wire:model.live="search" type="text" placeholder="Search messages"
                               class="h-9 w-full rounded-full border border-gray-300 bg-gray-100 pl-9 pr-3 text-sm outline-none focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/10" />
                    </div>
                </div>
                <ul class="min-h-0 flex-1 overflow-y-auto">
                    @foreach (collect($conversations)->filter(fn ($c) => $search === '' || Str::contains(Str::lower($c['name']), Str::lower($search))) as $conv)
                        <li>
                            <button wire:click="selectConversation({{ $conv['id'] }})" type="button"
                                    @class([
                                        'flex w-full items-center gap-3 px-4 py-3 text-left transition hover:bg-gray-50',
                                        'bg-blue-50' => $activeConversation === $conv['id'],
                                    ])>
                                <span class="relative shrink-0">
                                    <x-avatar :src="$conv['avatar'] ?? null" :name="$conv['name']" size="md" :online="$conv['online'] ?? false" />
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="truncate text-sm font-semibold text-gray-900">{{ $conv['name'] }}</p>
                                        <span class="shrink-0 text-xs text-gray-400">{{ $conv['time'] }}</span>
                                    </div>
                                    <div class="flex items-center justify-between gap-2">
                                        <p class="truncate text-xs text-gray-500">{{ $conv['last'] }}</p>
                                        @if (($conv['unread'] ?? 0) > 0)
                                            <span class="grid h-4 w-4 shrink-0 place-items-center rounded-full bg-blue-600 text-[9px] font-bold text-white">
                                                {{ $conv['unread'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Thread --}}
            <div class="flex flex-col {{ $activeConversation ? '' : 'max-lg:hidden' }} lg:flex lg:flex-col">
                @if ($activeConversation)
                    @php
                        $thread = $threads[$activeConversation] ?? [];
                        $conv = collect($conversations)->firstWhere('id', $activeConversation);
                    @endphp

                    {{-- Thread header --}}
                    <div class="flex items-center gap-3 border-b border-gray-200 px-4 py-3">
                        <button wire:click="backToList" type="button"
                                class="grid h-8 w-8 place-items-center rounded-full text-gray-500 transition hover:bg-gray-100 lg:hidden">
                            <x-icon name="chevron-down" class="h-5 w-5 rotate-90" />
                        </button>
                        <span class="relative shrink-0">
                            <x-avatar :src="$conv['avatar'] ?? null" :name="$conv['name']" size="sm" :online="$conv['online'] ?? false" />
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-gray-900">{{ $conv['name'] }}</p>
                            <p class="truncate text-xs text-gray-500">
                                {{ $conv['role'] }}
                                <span class="text-gray-300">·</span>
                                Last seen today at {{ $conv['time'] }}
                            </p>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div class="min-h-0 flex-1 space-y-3 overflow-y-auto px-4 py-4">
                        @foreach ($thread as $msg)
                            @if (($msg['from'] ?? 'them') === 'me')
                                <div class="flex justify-end">
                                    <div class="max-w-[75%] rounded-2xl rounded-br-sm bg-blue-600 px-3 py-2 text-sm text-white">
                                        <p class="whitespace-pre-line">{{ $msg['text'] }}</p>
                                        <p class="mt-1 text-right text-[10px] text-blue-100">{{ $msg['time'] }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="flex justify-start">
                                    <div class="max-w-[75%] rounded-2xl rounded-bl-sm bg-gray-100 px-3 py-2 text-sm text-gray-800">
                                        <p class="whitespace-pre-line">{{ $msg['text'] }}</p>
                                        <p class="mt-1 text-right text-[10px] text-gray-400">{{ $msg['time'] }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Composer --}}
                    <div class="border-t border-gray-200 p-3">
                        <div class="flex items-center gap-2">
                            <input wire:model="newMessage" type="text" placeholder="Write a message…"
                                   class="h-10 flex-1 rounded-full border border-gray-300 px-4 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" />
                            <button wire:click="sendMessage" type="button"
                                    class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-blue-600 text-white transition hover:bg-blue-700">
                                <x-icon name="paper-airplane" class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                @else
                    <div class="hidden items-center justify-center text-sm text-gray-400 lg:flex">
                        Select a conversation to start messaging.
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
