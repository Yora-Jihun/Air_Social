<x-card class="p-4 sm:p-5">
    <header class="flex items-center gap-3">
        <x-avatar :src="$post['avatar'] ?? null" :name="$post['author']" size="md" />

        <div class="min-w-0 flex-1">
            <p class="truncate font-semibold text-gray-900">{{ $post['author'] }}</p>
            <p class="truncate text-xs text-gray-500">
                {{ $post['role'] ?? '' }} · {{ $post['timestamp'] ?? '' }}
            </p>
        </div>

        <div x-data="{ menu: false }" class="relative" @click.outside="menu = false">
            <button type="button" @click="menu = ! menu" @contextmenu.prevent="menu = true"
                    aria-label="Post options"
                    class="grid h-8 w-8 place-items-center rounded-full text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                <x-icon name="ellipsis" class="h-5 w-5" />
            </button>

            <div x-show="menu" x-cloak
                 class="absolute right-0 top-9 z-30 w-44 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-lg">
                <button type="button"
                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-100">
                    {{ $post['visibility'] ?? 'Public' }}
                </button>
                <button type="button"
                        class="block w-full px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-100">
                    Copy link
                </button>
                <button type="button"
                        class="block w-full px-4 py-2 text-left text-sm text-red-600 transition hover:bg-gray-100">
                    Report post
                </button>
            </div>
        </div>
    </header>

    <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-gray-700">{{ $post['body'] }}</p>

    <div class="mt-4 flex items-center gap-1 border-t border-gray-100 pt-3">
        <div class="flex flex-1 items-center gap-1">
            {{-- Reaction: tap to cycle none → like → love → wow --}}
            <button type="button" wire:click="cycleReaction"
                    @class([
                        'inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-semibold transition hover:bg-gray-100',
                        'text-rose-600' => $reaction !== '',
                        'text-gray-500' => $reaction === '',
                    ])>
                @if ($this->reactionTotal() > 0)
                    <div class="flex -space-x-1.5">
                        @foreach ($this->reactionSummary() as $item)
                            <img src="{{ $item['src'] }}" alt="{{ $item['label'] }}"
                                 class="h-5 w-5 rounded-full bg-white object-contain ring-2 ring-white" />
                        @endforeach
                    </div>
                    <span class="text-xs tabular-nums">{{ $this->reactionTotal() }}</span>
                @else
                    <img src="{{ $this->reactionImage() }}" alt="{{ $this->reactionLabel() }}"
                         class="h-7 w-7 object-contain transition-transform duration-150 active:scale-90" />
                @endif
            </button>

            <button type="button"
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-semibold text-gray-500 transition hover:bg-gray-100">
                <img src="{{ asset('images/comment.png') }}" alt="Comment"
                     class="h-5 w-5 object-contain" />
                @if ($commentCount > 0)
                    <span class="tabular-nums">{{ $commentCount }}</span>
                @endif
            </button>

            <button type="button"
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-sm font-semibold text-gray-500 transition hover:bg-gray-100">
                <img src="{{ asset('images/share.png') }}" alt="Share"
                     class="h-5 w-5 object-contain" />
            </button>
        </div>

        <button type="button"
                class="inline-flex items-center rounded-full px-3 py-1.5 text-sm font-semibold text-gray-500 transition hover:bg-gray-100">
            <x-icon name="bookmark" class="h-5 w-5" />
        </button>
    </div>
</x-card>
