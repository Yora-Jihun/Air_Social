<div>
    <x-topbar :notification-count="3" :user-name="auth()->user()->name" />

    {{-- Cover + header --}}
    <div class="bg-white shadow-sm ring-1 ring-gray-200">
        <div class="h-36 w-full bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 sm:h-48"></div>

        <div class="mx-auto max-w-5xl px-4 py-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex items-end gap-4">
                    <x-avatar :src="$profile['avatar'] ?? null" :name="$profile['name']" size="xl"
                               class="ring-4 ring-white -mt-12 mb-2" />
                    <div class="pb-3">
                        <h1 class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $profile['name'] }}</h1>
                        <p class="text-sm text-gray-500">{{ $profile['headline'] }}</p>
                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500">
                            <span>{{ $profile['location'] }}</span>
                            <span>·</span>
                            <span class="font-medium text-gray-700">{{ $profile['joined'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 pb-3">
                    <button wire:click="openEdit" type="button"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-4 py-1.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                        <x-icon name="cog" class="h-4 w-4" />
                        Edit profile
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-5xl gap-1 overflow-x-auto px-2">
            @foreach (['posts' => 'Posts', 'about' => 'About', 'experience' => 'Experience', 'education' => 'Education', 'skills' => 'Skills'] as $key => $label)
                <button wire:click="setTab('{{ $key }}')" type="button"
                        @class([
                            'whitespace-nowrap border-b-2 px-4 py-3 text-sm font-medium transition',
                            'border-blue-600 text-blue-600' => $activeTab === $key,
                            'border-transparent text-gray-500 hover:text-gray-700' => $activeTab !== $key,
                        ])>
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Body --}}
    <div class="mx-auto max-w-5xl px-4 py-6">
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">

            {{-- Main column --}}
            <main class="space-y-4">
                @if ($activeTab === 'posts')
                    @foreach ($posts as $post)
                        <livewire:newsfeed.post-card :post="$post" :key="$post['id']" />
                    @endforeach

                @elseif ($activeTab === 'about')
                    <x-card class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900">About</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">{{ $profile['about'] }}</p>
                    </x-card>

                @elseif ($activeTab === 'experience')
                    <x-card class="divide-y divide-gray-100 p-5">
                        <h3 class="pb-3 text-sm font-semibold text-gray-900">Experience</h3>
                        @foreach ($profile['experience'] as $job)
                            <div class="flex gap-3 py-3">
                                <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-blue-50 text-blue-600">
                                    <x-icon name="briefcase" class="h-5 w-5" />
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $job['title'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $job['company'] }} · {{ $job['period'] }}</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ $job['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </x-card>

                @elseif ($activeTab === 'education')
                    <x-card class="divide-y divide-gray-100 p-5">
                        <h3 class="pb-3 text-sm font-semibold text-gray-900">Education</h3>
                        @foreach ($profile['education'] as $edu)
                            <div class="flex gap-3 py-3">
                                <div class="grid h-10 w-10 shrink-0 place-items-center rounded-lg bg-blue-50 text-blue-600">
                                    <x-icon name="user-group" class="h-5 w-5" />
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $edu['school'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $edu['degree'] }} · {{ $edu['period'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </x-card>

                @elseif ($activeTab === 'skills')
                    <x-card class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900">Skills</h3>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($profile['skills'] as $skill)
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">{{ $skill }}</span>
                            @endforeach
                        </div>
                    </x-card>
                @endif
            </main>

            {{-- Right sidebar --}}
            <aside class="space-y-4 lg:sticky lg:top-6">
                <x-card class="p-4">
                    <h3 class="text-sm font-semibold text-gray-900">Intro</h3>
                    <p class="mt-2 text-sm text-gray-600">{{ Str::limit($profile['about'], 120) }}</p>
                    <dl class="mt-3 space-y-1 text-sm">
                        <div class="flex items-center gap-2 text-gray-500">
                            <x-icon name="building" class="h-4 w-4" />
                            <span>{{ $profile['location'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-500">
                            <x-icon name="calendar" class="h-4 w-4" />
                            <span>{{ $profile['joined'] }}</span>
                        </div>
                    </dl>
                </x-card>

                <livewire:newsfeed.people-you-may-know-widget />
            </aside>

        </div>
    </div>

    {{-- Edit profile modal (static) --}}
    <style>
        @keyframes cp-pop {
            from { opacity: 0; transform: translateY(8px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .cp-modal { animation: cp-pop .18s ease-out; }
    </style>
    @if ($editOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
             wire:click="closeEdit" wire:key="edit-profile-modal">
            <div class="cp-modal flex max-h-[90vh] w-full max-w-lg flex-col overflow-hidden rounded-2xl bg-white shadow-2xl" wire:click.stop>
                <div class="relative border-b border-gray-200 px-4 py-3 text-center">
                    <h3 class="text-base font-bold text-gray-900">Edit profile</h3>
                    <button wire:click="closeEdit" type="button"
                            class="absolute right-3 top-1/2 grid h-8 w-8 -translate-y-1/2 place-items-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-200">
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                <div class="flex-1 space-y-4 overflow-y-auto px-4 py-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Headline</label>
                        <input wire:model="formHeadline" type="text"
                               class="mt-1 h-10 w-full rounded-lg border border-gray-300 px-3 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <input wire:model="formLocation" type="text"
                               class="mt-1 h-10 w-full rounded-lg border border-gray-300 px-3 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">About</label>
                        <textarea wire:model="formAbout" rows="4"
                                  class="mt-1 w-full resize-none rounded-lg border border-gray-300 px-3 py-2 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Skills <span class="font-normal text-gray-400">(comma separated)</span></label>
                        <input wire:model="formSkills" type="text"
                               class="mt-1 h-10 w-full rounded-lg border border-gray-300 px-3 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" />
                    </div>
                </div>

                <div class="border-t border-gray-200 px-4 py-3">
                    <div class="flex justify-end gap-2">
                        <button wire:click="closeEdit" type="button"
                                class="rounded-lg border border-gray-300 px-4 py-1.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Cancel
                        </button>
                        <button wire:click="saveProfile" type="button"
                                class="rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
