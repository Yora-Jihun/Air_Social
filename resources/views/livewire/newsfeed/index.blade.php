<div>
    <x-topbar :notification-count="3" :user-name="$username" />

    <div class="mx-auto max-w-7xl px-4 pb-12">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[260px_minmax(0,1fr)_320px] lg:items-start lg:pt-6">

            {{-- Left sidebar (fixed width, sticky) --}}
            <aside class="space-y-4 lg:sticky lg:top-6">
                <livewire:newsfeed.profile-card />
                <nav class="hidden rounded-xl bg-white p-2 shadow-sm ring-1 ring-gray-200 lg:block">
                    <x-sidebar-nav-item icon="home" label="News Feed" :active="true" href="#" />
                    <x-sidebar-nav-item icon="user-group" label="Friends" href="#" />
                    <x-sidebar-nav-item icon="users" label="Groups" href="#" />
                    <x-sidebar-nav-item icon="building" label="Companies" href="#" />
                    <x-sidebar-nav-item icon="calendar" label="Events" href="#" />
                    <x-sidebar-nav-item icon="briefcase" label="Jobs" href="#" />
                    <x-sidebar-nav-item icon="folder" label="Files" href="#" />
                    <x-sidebar-nav-item icon="bookmark" label="Saved" href="#" />
                </nav>
                <livewire:newsfeed.my-companies-widget />
            </aside>

            {{-- Center feed (flexible, max-width constrained) --}}
            <main class="space-y-4">
                <livewire:newsfeed.welcome-banner />

                @foreach ($posts as $post)
                    <livewire:newsfeed.post-card :post="$post" :key="$post['id']" />
                @endforeach

                <livewire:newsfeed.create-company-prompt />
            </main>

            {{-- Right aside (fixed width, sticky) --}}
            <aside class="hidden space-y-4 lg:block lg:sticky lg:top-6">
                <livewire:newsfeed.people-you-may-know-widget />
                <livewire:newsfeed.trending-companies-widget />
            </aside>

        </div>
    </div>
</div>
