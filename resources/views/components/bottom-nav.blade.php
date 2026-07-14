<nav class="fixed inset-x-0 bottom-0 z-40 border-t border-gray-200 bg-white lg:hidden">
    <div class="mx-auto flex max-w-5xl items-stretch justify-around px-2 py-1">
        <a href="{{ route('newsfeed') }}"
           @class(['flex flex-col items-center gap-0.5 px-3 py-1.5 text-xs', 'text-blue-600' => request()->routeIs('newsfeed'), 'text-gray-500' => ! request()->routeIs('newsfeed')])>
            <x-icon name="home" class="h-6 w-6" />
            <span>Home</span>
        </a>

        <a href="#"
           class="flex flex-col items-center gap-0.5 px-3 py-1.5 text-xs text-gray-500">
            <x-icon name="search" class="h-6 w-6" />
            <span>Search</span>
        </a>

        <a href="#"
           class="flex flex-col items-center gap-0.5 px-3 py-1.5 text-xs text-gray-500">
            <x-icon name="bell" class="h-6 w-6" />
            <span>Alerts</span>
        </a>

        <a href="{{ route('companies.show', ['slug' => 'bdo-unibank']) }}"
           @class(['flex flex-col items-center gap-0.5 px-3 py-1.5 text-xs', 'text-blue-600' => request()->routeIs('companies.show'), 'text-gray-500' => ! request()->routeIs('companies.show')])>
            <x-icon name="building" class="h-6 w-6" />
            <span>Companies</span>
        </a>

        <a href="{{ route('profile.show') }}"
           @class(['flex flex-col items-center gap-0.5 px-3 py-1.5 text-xs', 'text-blue-600' => request()->routeIs('profile.show'), 'text-gray-500' => ! request()->routeIs('profile.show')])>
            <x-icon name="user" class="h-6 w-6" />
            <span>Profile</span>
        </a>
    </div>
</nav>
