@props(['notificationCount' => 0, 'userName' => null, 'userAvatar' => null])

<header class="sticky top-0 z-40 border-b border-gray-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex max-w-7xl items-center gap-3 px-4 py-3">
            <a href="{{ route('newsfeed') }}" class="flex shrink-0 items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Air Social" class="h-8 w-8 object-contain">
            <span class="hidden text-lg font-extrabold tracking-tight text-gray-900 sm:block">Air Social</span>
        </a>

        <div class="flex flex-1 justify-center px-2">
            <div class="relative w-full max-w-md">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <x-icon name="search" class="h-5 w-5" />
                </span>
                <input type="search" placeholder="Search Air Social"
                       class="h-10 w-full rounded-full border border-gray-300 bg-gray-100 pl-10 pr-4 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/10">
            </div>
        </div>

        <div class="flex shrink-0 items-center gap-2 sm:gap-3">
            <nav class="hidden items-center gap-1 md:flex">
                <a href="#" aria-label="Apps"
                   class="grid h-10 w-10 place-items-center rounded-full text-gray-500 transition hover:bg-gray-100 hover:text-blue-600">
                    <x-icon name="grid" class="h-6 w-6" />
                </a>
                <a href="#" aria-label="Messages"
                    class="relative grid h-10 w-10 place-items-center rounded-full text-gray-500 transition hover:bg-gray-100 hover:text-blue-600">
                    <img src="{{ asset('images/chat.png') }}" alt="Messages"
                         class="h-5 w-5 object-contain" />
                    <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-blue-600"></span>
                </a>
                <div x-data="{ open: false }" class="relative">
                    <button type="button" @click="open = ! open" @click.outside="open = false" aria-label="Notifications"
                            class="relative grid h-10 w-10 place-items-center rounded-full text-gray-500 transition hover:bg-gray-100 hover:text-blue-600">
                        <x-icon name="bell" class="h-5 w-5" />
                        @if ($notificationCount > 0)
                            <span class="absolute right-1.5 top-1.5 grid h-4 w-4 place-items-center rounded-full bg-red-500 text-[9px] font-bold leading-none text-white ring-2 ring-white">
                                {{ $notificationCount }}
                            </span>
                        @endif
                    </button>

                    <div x-show="open" x-cloak x-transition.origin.top.right
                         class="absolute right-0 top-12 z-50 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg">
                        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-3">
                            <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            <button type="button" class="text-xs font-medium text-blue-600 hover:underline">Mark all read</button>
                        </div>

                        <ul class="max-h-80 divide-y divide-gray-100 overflow-y-auto">
                            <li class="flex gap-3 px-4 py-3 hover:bg-gray-50">
                                <x-avatar name="Maria Cristina Reyes" size="sm" />
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-700"><span class="font-semibold text-gray-900">Maria Cristina Reyes</span> commented on your post.</p>
                                    <p class="text-xs text-gray-400">2h</p>
                                </div>
                                <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>
                            </li>
                            <li class="flex gap-3 px-4 py-3 hover:bg-gray-50">
                                <x-avatar name="Juan Miguel Santos" size="sm" />
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-700"><span class="font-semibold text-gray-900">Juan Miguel Santos</span> mentioned you in Retail Banking.</p>
                                    <p class="text-xs text-gray-400">5h</p>
                                </div>
                                <span class="mt-1 h-2 w-2 shrink-0 rounded-full bg-blue-600"></span>
                            </li>
                            <li class="flex gap-3 px-4 py-3 hover:bg-gray-50">
                                <x-avatar name="Ana Marie Cruz" size="sm" />
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-gray-700"><span class="font-semibold text-gray-900">Ana Marie Cruz</span> sent you a connection request.</p>
                                    <p class="text-xs text-gray-400">1d</p>
                                </div>
                            </li>
                        </ul>

                        <a href="#" class="block border-t border-gray-100 px-4 py-3 text-center text-sm font-medium text-blue-600 hover:bg-gray-50">See all notifications</a>
                    </div>
                </div>
            </nav>

            <div x-data="{ open: false }" class="relative">
            <button type="button" @click="open = ! open" @click.outside="open = false"
                    class="flex items-center rounded-full transition hover:bg-gray-100">
                <x-avatar :src="$userAvatar" :name="$userName ?? 'You'" size="sm" />
            </button>

            <div x-show="open" x-cloak @click.outside="open = false"
                 class="absolute right-0 mt-2 w-48 overflow-hidden rounded-xl border border-gray-200 bg-white py-1 shadow-lg">
                <div class="border-b border-gray-100 px-4 py-2">
                    <p class="truncate text-sm font-semibold text-gray-900">{{ $userName ?? 'You' }}</p>
                </div>
                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100">View profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 transition hover:bg-gray-100">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="block w-full px-4 py-2 text-left text-sm text-red-600 transition hover:bg-gray-100">
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
</header>
