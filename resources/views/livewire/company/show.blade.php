<div>
    <x-topbar :notification-count="3" :user-name="auth()->user()->name" />

    {{-- Cover + header --}}
    <div class="bg-white shadow-sm ring-1 ring-gray-200">
        <div class="h-40 w-full bg-gradient-to-r from-blue-600 via-blue-700 to-blue-900 bg-cover bg-center sm:h-52"
             style="background-image: url('{{ $company['cover'] ?? '' }}')"></div>

        <div class="mx-auto max-w-5xl px-4 py-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex items-end gap-4">
                    <x-avatar :src="$company['logo'] ?? null" :name="$company['name']" size="xl"
                               class="ring-4 ring-white -mt-12 mb-2" />
                    <div class="pb-3">
                        <h1 class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $company['name'] }}</h1>
                        <p class="text-sm text-gray-500">{{ $company['tagline'] }} · {{ $company['industry'] }}</p>
                        <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500">
                            <span class="font-medium text-gray-700">{{ number_format($company['followers']) }} followers</span>
                            <span>{{ $company['location'] }}</span>
                            <span>{{ $company['size'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 pb-3">
                    @if ($company['is_admin'] ?? false)
                        <button type="button"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            <x-icon name="cog" class="h-4 w-4" />
                            Manage
                        </button>
                        <button wire:click="openPlugins" type="button"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-4 py-1.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            <x-icon name="blocks" class="h-4 w-4" />
                            Plugins
                        </button>
                    @elseif ($company['is_member'] ?? false)
                        <button type="button"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            <x-icon name="check" class="h-4 w-4" />
                            Joined
                        </button>
                    @else
                        <button type="button"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            <x-icon name="plus" class="h-4 w-4" />
                            Follow
                        </button>
                    @endif

                    @if (! ($company['is_admin'] ?? false))
                        <button type="button"
                                class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-4 py-1.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            <x-icon name="envelope" class="h-4 w-4" />
                            Message
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <div class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-5xl gap-1 overflow-x-auto px-2">
            @php
                $tabs = ['posts' => 'Posts', 'about' => 'About', 'people' => 'People', 'jobs' => 'Jobs', 'departments' => 'Departments'];
                if ($company['is_admin'] ?? false) {
                    foreach ($installedPlugins as $key) {
                        $manifest = ($this->pluginManifest())[$key] ?? null;
                        if ($manifest) {
                            $tabs[$key] = $manifest['name'];
                        }
                    }
                }
            @endphp
            @foreach ($tabs as $key => $label)
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
                    {{-- "Create post" trigger --}}
                    <x-card class="p-4">
                        <div class="flex items-center gap-3">
                            <x-avatar :src="null" :name="auth()->user()->name" size="md" />
                            <button wire:click="openCreatePost('company')" type="button"
                                    class="h-10 flex-1 rounded-full bg-gray-100 px-4 text-left text-sm text-gray-500 transition hover:bg-gray-200">
                                Share an update with {{ $company['name'] }}…
                            </button>
                        </div>
                    </x-card>

                    @foreach ($posts as $post)
                        <livewire:newsfeed.post-card :post="$post" :key="$post['id']" />
                    @endforeach
                @elseif ($activeTab === 'about')
                    <x-card class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900">About</h3>
                        <p class="mt-2 text-sm leading-relaxed text-gray-700">{{ $company['description'] }}</p>

                        <dl class="mt-4 grid grid-cols-1 gap-y-3 text-sm sm:grid-cols-2">
                            <div>
                                <dt class="text-gray-500">Industry</dt>
                                <dd class="font-medium text-gray-800">{{ $company['industry'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Company size</dt>
                                <dd class="font-medium text-gray-800">{{ $company['size'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Founded</dt>
                                <dd class="font-medium text-gray-800">{{ $company['founded'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Type</dt>
                                <dd class="font-medium text-gray-800">{{ $company['type'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Headquarters</dt>
                                <dd class="font-medium text-gray-800">{{ $company['location'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-500">Website</dt>
                                <dd class="font-medium text-blue-600">
                                    <a href="{{ $company['website'] }}" class="hover:underline">{{ $company['website'] }}</a>
                                </dd>
                            </div>
                        </dl>
                    </x-card>
                @elseif ($activeTab === 'people')
                    <x-card class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900">People you may know here</h3>
                        <ul class="mt-3 divide-y divide-gray-100">
                            @foreach ($people as $person)
                                <li class="flex items-center gap-3 py-3">
                                    <x-avatar :src="$person['avatar'] ?? null" :name="$person['name']" size="md" />
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-gray-800">{{ $person['name'] }}</p>
                                        <p class="truncate text-xs text-gray-500">{{ $person['role'] }}</p>
                                    </div>
                                    <x-connect-button />
                                </li>
                            @endforeach
                        </ul>
                    </x-card>
                @elseif ($activeTab === 'jobs')
                    <x-card class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900">Open roles</h3>
                        <ul class="mt-3 divide-y divide-gray-100">
                            @foreach ($jobs as $job)
                                <li class="flex items-center gap-3 py-3">
                                    <div class="grid h-10 w-10 place-items-center rounded-lg bg-blue-50 text-blue-600">
                                        <x-icon name="briefcase" class="h-5 w-5" />
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-gray-800">{{ $job['title'] }}</p>
                                        <p class="truncate text-xs text-gray-500">{{ $job['location'] }} · {{ $job['type'] }}</p>
                                    </div>
                                    <button type="button"
                                            class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">
                                        View
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </x-card>

                @elseif ($activeTab === 'departments')
                    @if ($selectedDept)
                        {{-- Department detail (creator / admin view) --}}
                        @php
                            $dept = collect($departments)->firstWhere('id', $selectedDept);
                        @endphp
                        <x-card class="p-5">
                            <button wire:click="backToDepartments" type="button"
                                    class="mb-3 inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-gray-700">
                                <x-icon name="chevron-down" class="h-4 w-4 rotate-90" />
                                All departments
                            </button>

                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-base font-bold text-gray-900">{{ $dept['name'] }}</h3>
                                    <p class="text-xs text-gray-500">{{ number_format($dept['member_count']) }} members</p>
                                </div>
                                <button type="button"
                                        class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50">
                                    Add member
                                </button>
                            </div>

                            {{-- Department-scoped composer trigger --}}
                            <x-card class="mt-4 p-4">
                                <div class="flex items-center gap-3">
                                    <x-avatar :src="null" :name="auth()->user()->name" size="md" />
                                    <button wire:click="openCreatePost('department', {{ $dept['id'] }})" type="button"
                                            class="h-10 flex-1 rounded-full bg-gray-100 px-4 text-left text-sm text-gray-500 transition hover:bg-gray-200">
                                        Write something to {{ $dept['name'] }}…
                                    </button>
                                </div>
                            </x-card>

                            {{-- Department-scoped feed --}}
                            <div class="mt-4 space-y-4">
                                @foreach ($dept['posts'] ?? [] as $post)
                                    <livewire:newsfeed.post-card :post="$post" :key="'dept-'.$post['id']" />
                                @endforeach
                                @if (empty($dept['posts']))
                                    <x-card class="p-6 text-center text-sm text-gray-400">
                                        No posts in this department yet.
                                    </x-card>
                                @endif
                            </div>

                            <h4 class="mt-6 text-xs font-semibold uppercase tracking-wide text-gray-400">Members</h4>
                            <ul class="mt-2 divide-y divide-gray-100">
                                @foreach ($dept['members'] as $member)
                                    <li class="flex items-center gap-3 py-3">
                                        <button wire:click="viewMember({{ $dept['id'] }}, '{{ $member['name'] }}')" type="button"
                                                class="flex min-w-0 flex-1 items-center gap-3 text-left">
                                            <x-avatar :src="$member['avatar'] ?? null" :name="$member['name']" size="md" />
                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-gray-800">{{ $member['name'] }}</p>
                                            </div>
                                        </button>
                                        @if (($member['role'] ?? '') === 'Lead')
                                            <span class="rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700">
                                                Department Admin
                                            </span>
                                        @else
                                            <button wire:click="setLead({{ $dept['id'] }}, '{{ $member['name'] }}')" type="button"
                                                    class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-semibold text-gray-600 transition hover:bg-gray-50">
                                                Make admin
                                            </button>
                                        @endif
                                    </li>
                                @endforeach
                                @if (empty($dept['members']))
                                    <li class="py-6 text-center text-sm text-gray-400">No members yet.</li>
                                @endif
                            </ul>
                        </x-card>
                    @else
                        {{-- Department list --}}
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900">Departments</h3>
                            <button wire:click="openCreateDept" type="button"
                                    class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                <x-icon name="plus" class="h-4 w-4" />
                                Create department
                            </button>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach ($departments as $dept)
                                <button wire:click="viewDepartment({{ $dept['id'] }})" type="button"
                                        class="rounded-xl bg-white p-4 text-left shadow-sm ring-1 ring-gray-200 transition hover:ring-blue-300">
                                    <div class="flex items-center gap-3">
                                        <div class="grid h-11 w-11 place-items-center rounded-lg bg-blue-50 text-blue-600">
                                            <x-icon name="building" class="h-5 w-5" />
                                        </div>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-gray-900">{{ $dept['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ number_format($dept['member_count']) }} members</p>
                                        </div>
                                    </div>
                                    @if ($dept['lead'])
                                        <p class="mt-3 text-xs text-gray-500">
                                            Admin: <span class="font-medium text-gray-700">{{ $dept['lead'] }}</span>
                                        </p>
                                    @else
                                        <p class="mt-3 text-xs text-gray-400">No department admin yet</p>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    @endif

                    {{-- Create department modal (static) --}}
                    @if ($createDeptOpen)
                        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
                             wire:key="create-dept-modal">
                            <div class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl">
                                <h3 class="text-base font-bold text-gray-900">Create department</h3>
                                <p class="mt-1 text-sm text-gray-500">Departments help organize your company's teams.</p>

                                <label class="mt-4 block text-sm font-medium text-gray-700">Department name</label>
                                <input wire:model="newDeptName" type="text" placeholder="e.g. Human Resources"
                                       class="mt-1 h-10 w-full rounded-lg border border-gray-300 px-3 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-600/10" />

                                <div class="mt-5 flex justify-end gap-2">
                                    <button wire:click="closeCreateDept" type="button"
                                            class="rounded-lg border border-gray-300 px-4 py-1.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                                        Cancel
                                    </button>
                                    <button wire:click="createDepartment" type="button"
                                            class="rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                @elseif ($activeTab === 'attendance')
                    <x-card class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Attendance</h3>
                                <p class="mt-1 text-sm text-gray-500">Manage attendance · preview</p>
                            </div>
                            <button wire:click="expandPlugin('attendance')" type="button" title="Expand"
                                    class="grid h-8 w-8 shrink-0 place-items-center rounded-lg border border-gray-300 text-gray-600 transition hover:bg-gray-50">
                                <x-icon name="expand" class="h-4 w-4" />
                            </button>
                        </div>
                        <div class="mt-4 max-h-[70vh]">
                            @include('livewire.company.partials.attendance-table')
                        </div>
                    </x-card>
                @elseif ($activeTab === 'payroll')
                    <x-card class="p-5">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">Payroll</h3>
                                <p class="mt-1 text-sm text-gray-500">Run payroll and track compensation · preview</p>
                            </div>
                            <button wire:click="expandPlugin('payroll')" type="button" title="Expand"
                                    class="grid h-8 w-8 shrink-0 place-items-center rounded-lg border border-gray-300 text-gray-600 transition hover:bg-gray-50">
                                <x-icon name="expand" class="h-4 w-4" />
                            </button>
                        </div>
                        <div class="mt-4 max-h-[70vh]">
                            @include('livewire.company.partials.payroll-table')
                        </div>
                    </x-card>
                @elseif (in_array($activeTab, $installedPlugins, true))
                    @php
                        $manifest = ($this->pluginManifest())[$activeTab] ?? null;
                    @endphp
                    <x-card class="p-5">
                        <h3 class="text-sm font-semibold text-gray-900">{{ $manifest['name'] ?? 'Plugin' }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ $manifest['desc'] ?? '' }}</p>
                        <p class="mt-4 text-sm text-gray-400">This plugin is installed. Content is coming soon.</p>
                    </x-card>
                @endif
            </main>

            {{-- Right sidebar --}}
            <aside class="hidden space-y-4 lg:block lg:sticky lg:top-6">
                <x-card class="p-4">
                    <h3 class="text-sm font-semibold text-gray-900">Admins</h3>
                    <ul class="mt-3 space-y-3">
                        @foreach ($admins as $admin)
                            <li class="flex items-center gap-3">
                                <x-avatar :src="$admin['avatar'] ?? null" :name="$admin['name']" size="sm" />
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-medium text-gray-800">{{ $admin['name'] }}</p>
                                    <p class="truncate text-xs text-gray-500">{{ $admin['role'] }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </x-card>

                <x-card class="p-4">
                    <div class="flex items-center justify-between px-1">
                        <h3 class="text-sm font-semibold text-gray-900">Similar companies</h3>
                    </div>
                    <ul class="mt-3 space-y-1">
                        @foreach ($related as $rel)
                            <li>
                                <a href="#" class="flex items-center gap-3 rounded-lg px-1 py-2 hover:bg-gray-50">
                                    <x-avatar :src="$rel['avatar'] ?? null" :name="$rel['name']" size="sm" />
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-medium text-gray-800">{{ $rel['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ number_format($rel['members']) }} members</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </x-card>
            </aside>

        </div>
    </div>

    {{-- Create post modal (composer style) --}}
    <style>
        @keyframes cp-pop {
            from { opacity: 0; transform: translateY(8px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .cp-modal { animation: cp-pop .18s ease-out; }
    </style>
    @if ($createPostOpen)
        <div class="fixed inset-0 z-50 flex items-end justify-center bg-slate-900/60 px-0 backdrop-blur-sm sm:items-center sm:px-4"
             wire:click="closeCreatePost" wire:key="create-post-modal">
            <div class="cp-modal flex max-h-[92vh] w-full max-w-xl flex-col overflow-hidden rounded-t-2xl bg-white shadow-2xl ring-1 ring-black/5 sm:rounded-2xl" wire:click.stop>

                {{-- Gradient header --}}
                <div class="relative bg-blue-600 px-5 py-4">
                    <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-white/70">Company update</p>
                    <h3 class="mt-0.5 text-lg font-bold text-white">Create a post</h3>
                    <button wire:click="closeCreatePost" type="button"
                            class="absolute right-3 top-3 grid h-8 w-8 place-items-center rounded-full bg-white/15 text-white transition hover:bg-white/30">
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                {{-- Scrollable content --}}
                <div class="flex-1 overflow-y-auto px-5 py-4">
                    {{-- Author --}}
                    <div class="flex items-center gap-3">
                        <x-avatar :src="null" :name="auth()->user()->name" size="md" />
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-400">Posting to {{ $company['name'] ?? 'this company' }}</p>
                        </div>
                    </div>

                    {{-- Body --}}
                    <textarea wire:model.live="newPost" rows="5" maxlength="500" autofocus
                              placeholder="Share an update with your team…"
                              class="mt-4 w-full resize-none border-0 p-0 text-lg leading-relaxed text-slate-800 outline-none placeholder:text-slate-400"></textarea>

                    {{-- Add to your post --}}
                    <div class="mt-4 flex items-center gap-2 overflow-x-auto pb-1">
                        <button type="button" class="flex shrink-0 items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-200">
                            <x-icon name="image" class="h-4 w-4 text-rose-500" /> Photo
                        </button>
                        <button type="button" class="flex shrink-0 items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-200">
                            <x-icon name="building" class="h-4 w-4 text-blue-600" /> Tag company
                        </button>
                        <button type="button" class="flex shrink-0 items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-200">
                            <x-icon name="calendar" class="h-4 w-4 text-amber-500" /> Event
                        </button>
                        <button type="button" class="flex shrink-0 items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-xs font-medium text-slate-600 transition hover:bg-slate-200">
                            <x-icon name="user-group" class="h-4 w-4 text-violet-500" /> Tag people
                        </button>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="border-t border-slate-100 px-5 py-3">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-xs font-medium text-slate-400">{{ $newPost ? Str::length($newPost) : 0 }}/500</span>
                        <button wire:click="createPost" type="button"
                                @if ($newPost === '') disabled @endif
                                class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50">
                            <x-icon name="paper-airplane" class="h-4 w-4" /> Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Member profile modal (admin view, static) --}}
    @if ($selectedMember)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
             wire:click="closeMember" wire:key="member-modal">
            <div class="cp-modal w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl" wire:click.stop>
                {{-- Header --}}
                <div class="flex items-center gap-3 border-b border-gray-200 px-4 py-4">
                    <x-avatar :src="$selectedMember['avatar'] ?? null" :name="$selectedMember['name']" size="lg" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-base font-bold text-gray-900">{{ $selectedMember['name'] }}</p>
                        <p class="truncate text-sm text-gray-500">{{ $selectedMember['role'] }} · {{ $selectedMember['department'] }}</p>
                    </div>
                    <button wire:click="closeMember" type="button"
                            class="grid h-8 w-8 place-items-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-200">
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                <div class="max-h-[70vh] space-y-4 overflow-y-auto px-4 py-4">
                    {{-- Public info --}}
                    <div>
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Public info</h4>
                        <dl class="mt-2 divide-y divide-gray-100 rounded-xl border border-gray-200">
                            @foreach ($selectedMember['public'] ?? [] as $row)
                                <div class="flex justify-between gap-3 px-3 py-2 text-sm">
                                    <dt class="text-gray-500">{{ $row['label'] }}</dt>
                                    <dd class="truncate font-medium text-gray-800">{{ $row['value'] }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>

                    {{-- Private documents (admin only) --}}
                    <div class="rounded-xl border border-amber-200 bg-amber-50/40 p-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-amber-700">
                                <x-icon name="lock" class="h-4 w-4" />
                                <h4 class="text-xs font-semibold uppercase tracking-wide">Private documents</h4>
                            </div>
                            <button wire:click="toggleReveal" type="button"
                                    class="rounded-lg border border-amber-300 bg-white px-3 py-1 text-xs font-semibold text-amber-700 transition hover:bg-amber-100">
                                {{ $revealPrivate ? 'Hide' : 'Reveal' }}
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-amber-600">Only visible to company/department admins. Reveals are logged.</p>

                        <dl class="mt-2 divide-y divide-amber-100 rounded-lg bg-white">
                            @foreach ($selectedMember['private'] ?? [] as $doc)
                                <div class="flex justify-between gap-3 px-3 py-2 text-sm">
                                    <dt class="text-gray-500">{{ $doc['label'] }}</dt>
                                    <dd class="truncate font-medium text-gray-800">
                                        @if ($revealPrivate)
                                            {{ $doc['value'] }}
                                        @elseif ($doc['type'] === 'assets')
                                            <span class="text-gray-400">Assigned assets (hidden)</span>
                                        @else
                                            •••• {{ substr($doc['value'], -4) }}
                                        @endif
                                    </dd>
                                </div>
                            @endforeach
                        </dl>

                        @if ($revealPrivate)
                            <p class="mt-2 text-[11px] text-amber-600">Viewed by you · just now (audit logged)</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Payroll breakdown / payslip modal (static, view-only) --}}
    @if ($payslipIndex !== null && isset($payrollRecords[$payslipIndex]))
        @php
            $payslip = $payrollRecords[$payslipIndex];
            $gross = $payslip['gross_pay'];
            $deductionsTotal = array_sum($payslip['deductions'] ?? []);
        @endphp
        <style>
            @media print {
                body * { visibility: hidden; }
                #payslip-print, #payslip-print * { visibility: visible; }
                #payslip-print { position: fixed; inset: 0; padding: 32px; }
            }
        </style>
        <div class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 px-4"
             wire:click="closePayslip" wire:key="payslip-modal">
            <div class="cp-modal w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl" wire:click.stop>

                @if (! $showGeneratedPayslip)
                    {{-- Breakdown view --}}
                    <div class="flex items-center gap-3 border-b border-gray-200 px-4 py-4">
                        <x-avatar :src="$payslip['avatar'] ?? null" :name="$payslip['name']" size="lg" />
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-base font-bold text-gray-900">{{ $payslip['name'] }}</p>
                            <p class="truncate text-sm text-gray-500">{{ $payslip['position'] }} · {{ $payslip['employee_id'] }}</p>
                        </div>
                        <button wire:click="closePayslip" type="button"
                                class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-200">
                            <x-icon name="x" class="h-5 w-5" />
                        </button>
                    </div>

                    <div class="max-h-[70vh] space-y-4 overflow-y-auto px-4 py-4">
                        <div class="flex items-center justify-between rounded-lg bg-gray-50 px-3 py-2 text-xs text-gray-500">
                            <span>Pay period: <span class="font-medium text-gray-700">{{ $this->payrollPeriodLabel() }}</span></span>
                            @if ($payslip['status'] === 'paid')
                                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">Paid</span>
                            @else
                                <span class="rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-semibold text-amber-700">Pending</span>
                            @endif
                        </div>

                        {{-- Attendance summary this payroll run was computed from --}}
                        <div class="grid grid-cols-4 gap-2 text-center text-xs">
                            <div class="rounded-lg border border-gray-200 p-2">
                                <p class="text-[10px] text-gray-500">Present</p>
                                <p class="mt-0.5 font-bold text-emerald-600">{{ $payslip['days_present'] }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 p-2">
                                <p class="text-[10px] text-gray-500">Absent</p>
                                <p class="mt-0.5 font-bold text-rose-600">{{ $payslip['days_absent'] }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 p-2">
                                <p class="text-[10px] text-gray-500">Leave</p>
                                <p class="mt-0.5 font-bold text-violet-600">{{ $payslip['days_leave'] }}</p>
                            </div>
                            <div class="rounded-lg border border-gray-200 p-2">
                                <p class="text-[10px] text-gray-500">Late</p>
                                <p class="mt-0.5 font-bold text-orange-600">{{ $payslip['days_late'] }}</p>
                            </div>
                        </div>
                        @if (! empty($payslip['holidays_worked']))
                            <p class="rounded-lg bg-yellow-50 px-3 py-2 text-xs text-yellow-800">
                                <span class="font-semibold">Worked on {{ implode(', ', $payslip['holidays_worked']) }}</span> — holiday pay applied.
                            </p>
                        @endif

                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Earnings</h4>
                            <dl class="mt-2 divide-y divide-gray-100 rounded-xl border border-gray-200">
                                <div class="flex justify-between px-3 py-2 text-sm">
                                    <dt class="text-gray-500">Basic pay ({{ $payslip['days_present'] }} days × ₱{{ number_format($payslip['daily_rate'], 2) }})</dt>
                                    <dd class="font-medium text-gray-800">₱{{ number_format($payslip['base_pay'], 2) }}</dd>
                                </div>
                                @if ($payslip['holiday_pay'] > 0)
                                    <div class="flex justify-between px-3 py-2 text-sm">
                                        <dt class="text-gray-500">Holiday pay premium</dt>
                                        <dd class="font-medium text-gray-800">₱{{ number_format($payslip['holiday_pay'], 2) }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between px-3 py-2 text-sm">
                                    <dt class="text-gray-500">Overtime pay</dt>
                                    <dd class="font-medium text-gray-800">₱{{ number_format($payslip['overtime'], 2) }}</dd>
                                </div>
                                @if ($payslip['late_deduction'] > 0)
                                    <div class="flex justify-between px-3 py-2 text-sm">
                                        <dt class="text-gray-500">Late deduction ({{ $payslip['days_late'] }} day{{ $payslip['days_late'] === 1 ? '' : 's' }})</dt>
                                        <dd class="font-medium text-orange-600">-₱{{ number_format($payslip['late_deduction'], 2) }}</dd>
                                    </div>
                                @endif
                                <div class="flex justify-between bg-gray-50 px-3 py-2 text-sm">
                                    <dt class="font-medium text-gray-600">Gross pay</dt>
                                    <dd class="font-semibold text-gray-900">₱{{ number_format($gross, 2) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Deductions</h4>
                            <dl class="mt-2 divide-y divide-gray-100 rounded-xl border border-gray-200">
                                <div class="flex justify-between px-3 py-2 text-sm">
                                    <dt class="text-gray-500">SSS</dt>
                                    <dd class="font-medium text-rose-600">-₱{{ number_format($payslip['deductions']['sss'] ?? 0, 2) }}</dd>
                                </div>
                                <div class="flex justify-between px-3 py-2 text-sm">
                                    <dt class="text-gray-500">PhilHealth</dt>
                                    <dd class="font-medium text-rose-600">-₱{{ number_format($payslip['deductions']['philhealth'] ?? 0, 2) }}</dd>
                                </div>
                                <div class="flex justify-between px-3 py-2 text-sm">
                                    <dt class="text-gray-500">Pag-IBIG</dt>
                                    <dd class="font-medium text-rose-600">-₱{{ number_format($payslip['deductions']['pagibig'] ?? 0, 2) }}</dd>
                                </div>
                                <div class="flex justify-between px-3 py-2 text-sm">
                                    <dt class="text-gray-500">Withholding tax</dt>
                                    <dd class="font-medium text-rose-600">-₱{{ number_format($payslip['deductions']['tax'] ?? 0, 2) }}</dd>
                                </div>
                                <div class="flex justify-between bg-gray-50 px-3 py-2 text-sm">
                                    <dt class="font-medium text-gray-600">Total deductions</dt>
                                    <dd class="font-semibold text-rose-600">-₱{{ number_format($deductionsTotal, 2) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="flex items-center justify-between rounded-xl bg-blue-50 px-4 py-3">
                            <span class="text-sm font-semibold text-blue-900">Net pay</span>
                            <span class="text-lg font-bold text-blue-900">₱{{ number_format($payslip['net_pay'], 2) }}</span>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 border-t border-gray-100 px-4 py-3">
                        <button wire:click="closePayslip" type="button"
                                class="rounded-lg border border-gray-300 px-4 py-1.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Close
                        </button>
                        <button wire:click="generatePayslip" type="button"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            <x-icon name="briefcase" class="h-4 w-4" />
                            Generate payslip
                        </button>
                    </div>
                @else
                    {{-- Generated payslip (printable) view --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-3 print:hidden">
                        <button wire:click="backToPayslipBreakdown" type="button"
                                class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 transition hover:text-gray-700">
                            <x-icon name="chevron-down" class="h-4 w-4 rotate-90" />
                            Back
                        </button>
                        <button wire:click="closePayslip" type="button"
                                class="grid h-8 w-8 place-items-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-200">
                            <x-icon name="x" class="h-5 w-5" />
                        </button>
                    </div>

                    <div id="payslip-print" class="max-h-[75vh] overflow-y-auto px-6 py-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-base font-bold text-gray-900">{{ $company['name'] ?? 'Company' }}</p>
                                <p class="text-xs text-gray-500">{{ $company['location'] ?? '' }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold uppercase tracking-wide text-gray-700">Payslip</p>
                                <p class="text-xs text-gray-500">{{ $this->payrollPeriodLabel() }}</p>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 rounded-xl border border-gray-200 p-3 text-sm">
                            <div>
                                <p class="text-xs text-gray-400">Employee name</p>
                                <p class="font-medium text-gray-800">{{ $payslip['name'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Employee ID</p>
                                <p class="font-medium text-gray-800">{{ $payslip['employee_id'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Position</p>
                                <p class="font-medium text-gray-800">{{ $payslip['position'] }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Pay date</p>
                                <p class="font-medium text-gray-800">{{ $payslip['pay_date'] ?? '' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Days present / absent / leave</p>
                                <p class="font-medium text-gray-800">{{ $payslip['days_present'] }} / {{ $payslip['days_absent'] }} / {{ $payslip['days_leave'] }}</p>
                            </div>
                            @if (! empty($payslip['holidays_worked']))
                                <div>
                                    <p class="text-xs text-gray-400">Holiday(s) worked</p>
                                    <p class="font-medium text-gray-800">{{ implode(', ', $payslip['holidays_worked']) }}</p>
                                </div>
                            @endif
                        </div>

                        <table class="mt-4 w-full border-collapse text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-400">
                                    <th class="py-2">Earnings</th>
                                    <th class="py-2 text-right">Amount</th>
                                    <th class="py-2 pl-6">Deductions</th>
                                    <th class="py-2 text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-gray-100">
                                    <td class="py-1.5 text-gray-600">Basic pay</td>
                                    <td class="py-1.5 text-right text-gray-800">₱{{ number_format($payslip['base_pay'], 2) }}</td>
                                    <td class="py-1.5 pl-6 text-gray-600">SSS</td>
                                    <td class="py-1.5 text-right text-gray-800">₱{{ number_format($payslip['deductions']['sss'] ?? 0, 2) }}</td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-1.5 text-gray-600">Holiday pay premium</td>
                                    <td class="py-1.5 text-right text-gray-800">{{ $payslip['holiday_pay'] > 0 ? '₱'.number_format($payslip['holiday_pay'], 2) : '—' }}</td>
                                    <td class="py-1.5 pl-6 text-gray-600">PhilHealth</td>
                                    <td class="py-1.5 text-right text-gray-800">₱{{ number_format($payslip['deductions']['philhealth'] ?? 0, 2) }}</td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-1.5 text-gray-600">Overtime pay</td>
                                    <td class="py-1.5 text-right text-gray-800">₱{{ number_format($payslip['overtime'], 2) }}</td>
                                    <td class="py-1.5 pl-6 text-gray-600">Pag-IBIG</td>
                                    <td class="py-1.5 text-right text-gray-800">₱{{ number_format($payslip['deductions']['pagibig'] ?? 0, 2) }}</td>
                                </tr>
                                <tr class="border-b border-gray-100">
                                    <td class="py-1.5 text-gray-600">Late deduction</td>
                                    <td class="py-1.5 text-right text-orange-600">{{ $payslip['late_deduction'] > 0 ? '-₱'.number_format($payslip['late_deduction'], 2) : '—' }}</td>
                                    <td class="py-1.5 pl-6 text-gray-600">Withholding tax</td>
                                    <td class="py-1.5 text-right text-gray-800">₱{{ number_format($payslip['deductions']['tax'] ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 font-semibold text-gray-700">Gross pay</td>
                                    <td class="py-1.5 text-right font-semibold text-gray-900">₱{{ number_format($gross, 2) }}</td>
                                    <td class="py-1.5 pl-6 font-semibold text-gray-700">Total deductions</td>
                                    <td class="py-1.5 text-right font-semibold text-rose-600">₱{{ number_format($deductionsTotal, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 flex items-center justify-between rounded-xl bg-blue-50 px-4 py-3">
                            <span class="text-sm font-semibold text-blue-900">Net pay</span>
                            <span class="text-lg font-bold text-blue-900">₱{{ number_format($payslip['net_pay'], 2) }}</span>
                        </div>

                        <div class="mt-8 grid grid-cols-2 gap-6 text-xs text-gray-500">
                            <div>
                                <div class="h-10 border-b border-gray-300"></div>
                                <p class="mt-1">Prepared by</p>
                            </div>
                            <div>
                                <div class="h-10 border-b border-gray-300"></div>
                                <p class="mt-1">Approved by</p>
                            </div>
                        </div>
                        <p class="mt-4 text-center text-[11px] text-gray-400">This is a system-generated payslip for preview purposes.</p>
                    </div>

                    <div class="flex justify-end gap-2 border-t border-gray-100 px-4 py-3 print:hidden">
                        <button wire:click="backToPayslipBreakdown" type="button"
                                class="rounded-lg border border-gray-300 px-4 py-1.5 text-sm font-semibold text-gray-700 transition hover:bg-gray-50">
                            Back
                        </button>
                        <button onclick="window.print()" type="button"
                                class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-4 py-1.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                            <x-icon name="printer" class="h-4 w-4" />
                            Print
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Attendance history modal (static, view-only) --}}
    @if ($attendanceHistoryEmployee)
        @php
            $historyDays = $this->attendanceHistoryDays();
            $statusMeta = $this->attendanceStatusMeta();
            $rangeOptions = $this->attendanceHistoryRangeOptions();
            $workingDays = collect($historyDays)->filter(fn ($d) => $d['status'] !== 'weekend');
            $statusCounts = $workingDays->countBy('status');
            $totalWorking = $workingDays->count();
            $attendanceRate = $totalWorking > 0 ? (int) round(($statusCounts->get('present', 0) / $totalWorking) * 100) : 0;

            $gradientStops = [];
            $cursor = 0;
            foreach ($statusMeta as $statusKey => $meta) {
                $count = $statusCounts->get($statusKey, 0);
                if ($count <= 0) {
                    continue;
                }
                $pct = $totalWorking > 0 ? ($count / $totalWorking) * 100 : 0;
                $start = $cursor;
                $cursor += $pct;
                $gradientStops[] = "{$meta['hex']} {$start}% {$cursor}%";
            }
            $gradientCss = count($gradientStops) ? implode(', ', $gradientStops) : '#e5e7eb 0% 100%';

            // Status totals, sorted highest to lowest — re-sorts automatically whenever the cutoff changes.
            $sortedStatuses = collect($statusMeta)
                ->map(fn ($meta, $statusKey) => $meta + ['key' => $statusKey, 'count' => $statusCounts->get($statusKey, 0)])
                ->sortByDesc('count')
                ->values();
            $maxStatusCount = max(1, $sortedStatuses->max('count'));

            // Per-day hours bar graph only makes sense for the shorter cutoffs; a year of bars is unreadable.
            $showDailyBars = in_array($attendanceHistoryRange, ['7', '15', '30'], true);
            $maxHours = max(8, collect($historyDays)->max('hours'));

            // "Late" is a flag on top of Present (logged under a full 10h shift), not its own status.
            $lateMeta = $this->attendanceLateMeta();
            $lateDays = $workingDays->filter(fn ($d) => ! empty($d['late_minutes']));
            $lateCount = $lateDays->count();

            // PH holidays are a flag too — shown alongside status/late, same as in Payroll.
            $holidayMeta = $this->attendanceHolidayMeta();
        @endphp
        <div class="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 px-4"
             wire:click="closeAttendanceHistory" wire:key="attendance-history-modal">
            <div class="cp-modal w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-2xl" wire:click.stop>
                <div class="flex items-center gap-3 border-b border-gray-200 px-4 py-4">
                    <x-avatar :name="$attendanceHistoryEmployee" size="lg" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-base font-bold text-gray-900">{{ $attendanceHistoryEmployee }}</p>
                        <p class="truncate text-sm text-gray-500">Attendance history</p>
                    </div>
                    <button wire:click="closeAttendanceHistory" type="button"
                            class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-200">
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                <div class="max-h-[75vh] space-y-5 overflow-y-auto px-4 py-4">
                    {{-- Range tabs --}}
                    <div class="flex flex-wrap gap-1.5 rounded-lg bg-gray-100 p-1">
                        @foreach ($rangeOptions as $rangeKey => $rangeLabel)
                            <button wire:click="setAttendanceHistoryRange('{{ $rangeKey }}')" type="button"
                                    class="flex-1 rounded-md px-3 py-1.5 text-xs font-semibold transition {{ $attendanceHistoryRange === $rangeKey ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                {{ $rangeLabel }}
                            </button>
                        @endforeach
                    </div>

                    {{-- Summary tiles --}}
                    <div class="grid grid-cols-3 gap-2 sm:grid-cols-6">
                        <div class="rounded-xl border border-gray-200 p-2.5 text-center">
                            <p class="text-[11px] text-gray-500">Rate</p>
                            <p class="mt-0.5 text-base font-bold text-gray-900">{{ $attendanceRate }}%</p>
                        </div>
                        <div class="rounded-xl border border-gray-200 p-2.5 text-center">
                            <p class="text-[11px] text-gray-500">Late</p>
                            <p class="mt-0.5 text-base font-bold {{ $lateMeta['text'] }}">{{ $lateCount }}</p>
                        </div>
                        @foreach ($statusMeta as $statusKey => $meta)
                            <div class="rounded-xl border border-gray-200 p-2.5 text-center">
                                <p class="text-[11px] text-gray-500">{{ $meta['label'] }}</p>
                                <p class="mt-0.5 text-base font-bold {{ $meta['text'] }}">{{ $statusCounts->get($statusKey, 0) }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Donut chart + legend --}}
                    <div class="flex flex-col items-center gap-4 rounded-xl border border-gray-200 p-4 sm:flex-row">
                        <div class="h-32 w-32 shrink-0 rounded-full" style="background: conic-gradient({{ $gradientCss }});">
                            <div class="relative left-1/2 top-1/2 grid h-20 w-20 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full bg-white text-center shadow-inner">
                                <div>
                                    <p class="text-lg font-bold text-gray-900">{{ $attendanceRate }}%</p>
                                    <p class="text-[10px] text-gray-400">present</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 space-y-2">
                            <p class="text-[11px] font-semibold uppercase tracking-wide text-gray-400">Breakdown · sorted by cutoff</p>
                            @foreach ($sortedStatuses as $meta)
                                <div class="flex items-center gap-2 text-xs">
                                    <span class="w-28 shrink-0 truncate text-gray-600">{{ $meta['label'] }}</span>
                                    <span class="h-2.5 flex-1 overflow-hidden rounded-full bg-gray-100">
                                        <span class="block h-full rounded-full {{ $meta['dot'] }}" style="width: {{ ($meta['count'] / $maxStatusCount) * 100 }}%"></span>
                                    </span>
                                    <span class="w-14 shrink-0 text-right font-semibold text-gray-800">
                                        {{ $meta['count'] }}
                                        <span class="font-normal text-gray-400">({{ $totalWorking > 0 ? round(($meta['count'] / $totalWorking) * 100) : 0 }}%)</span>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Daily hours bar graph (7 / 15 / 30 day cutoffs only) --}}
                    @if ($showDailyBars)
                        @php
                            $gridLines = [$maxHours, round($maxHours / 2, 1), 0];
                        @endphp
                        <div>
                            <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Hours per day</h4>
                            <div class="mt-2 rounded-xl border border-gray-200 bg-gray-50/40 p-4">
                                {{-- Chart area: y-axis gridlines + bars, absolutely stacked --}}
                                <div class="relative h-44">
                                    <div class="absolute inset-0 flex flex-col justify-between">
                                        @foreach ($gridLines as $line)
                                            <div class="flex items-center gap-2">
                                                <span class="w-7 shrink-0 text-right text-[9px] text-gray-400">{{ $line }}h</span>
                                                <span class="h-px flex-1 border-t border-dashed border-gray-200"></span>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="absolute inset-0 flex items-end gap-1.5 pl-9">
                                        @foreach ($historyDays as $day)
                                            @php
                                                $meta = $statusMeta[$day['status']] ?? null;
                                                $barPx = $day['hours'] > 0 ? max(14, (int) round(($day['hours'] / $maxHours) * 152)) : 6;
                                            @endphp
                                            <div class="group relative flex min-w-0 flex-1 flex-col items-center">
                                                {{-- Floating tooltip --}}
                                                <div class="pointer-events-none absolute bottom-full left-1/2 z-30 mb-2 hidden w-48 -translate-x-1/2 rounded-lg bg-gray-900 px-3 py-2 text-[11px] leading-relaxed text-white shadow-xl group-hover:block">
                                                    <p class="flex items-center gap-1.5 font-semibold">
                                                        <span class="h-2 w-2 shrink-0 rounded-full {{ $meta['dot'] ?? 'bg-gray-400' }}"></span>
                                                        {{ \Carbon\Carbon::parse($day['date'])->format('M j, Y (D)') }}
                                                    </p>
                                                    <p class="mt-0.5 text-gray-300">
                                                        {{ $meta['label'] ?? 'Weekend' }}@if ($day['hours'] > 0) · {{ $day['hours'] }}h logged @endif
                                                    </p>
                                                    @if ($day['time_in'])
                                                        <p class="mt-1 text-gray-300">{{ $day['time_in'] }} – {{ $day['time_out'] }}</p>
                                                    @endif
                                                    @if ($day['location'])
                                                        <p class="mt-1 text-gray-300">{{ $day['location'] }}</p>
                                                        <p class="text-gray-300">{{ $day['weather'] }} · {{ $day['altitude'] }}</p>
                                                    @endif
                                                    @if ($day['late_minutes'])
                                                        <p class="mt-1 font-semibold text-orange-400">{{ $this->formatLateDuration($day['late_minutes']) }}</p>
                                                    @endif
                                                    @if ($day['holiday_name'])
                                                        <p class="mt-1 font-semibold text-yellow-400">{{ $day['holiday_name'] }} ({{ $holidayMeta[$day['holiday_type']]['label'] ?? 'Holiday' }})</p>
                                                    @endif
                                                    <span class="absolute left-1/2 top-full h-0 w-0 -translate-x-1/2 border-4 border-transparent border-t-gray-900"></span>
                                                </div>

                                                @if ($day['hours'] > 0)
                                                    <span class="mb-1 flex items-center gap-1 text-[9px] font-semibold text-gray-500">
                                                        {{ $day['hours'] }}h
                                                        @if ($day['late_minutes'])
                                                            <span class="h-1.5 w-1.5 rounded-full bg-orange-500"></span>
                                                        @endif
                                                    </span>
                                                @endif
                                                <div class="w-full max-w-[28px] rounded-t transition group-hover:brightness-110 {{ $meta['dot'] ?? 'bg-gray-200' }}"
                                                     style="height: {{ $barPx }}px"></div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- x-axis date labels, aligned under the bars --}}
                                <div class="mt-2 flex gap-1.5 pl-9">
                                    @foreach ($historyDays as $day)
                                        <span class="min-w-0 flex-1 text-center text-[9px] text-gray-400">{{ \Carbon\Carbon::parse($day['date'])->format('n/j') }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Day-by-day strip --}}
                    <div x-data="{ hovered: null }">
                        <h4 class="text-xs font-semibold uppercase tracking-wide text-gray-400">Daily breakdown</h4>
                        <div class="mt-2 flex flex-wrap gap-1 rounded-xl border border-gray-200 p-3">
                            @foreach ($historyDays as $day)
                                @php
                                    $meta = $statusMeta[$day['status']] ?? null;
                                    $tooltip = [
                                        'date' => \Carbon\Carbon::parse($day['date'])->format('M j, Y (D)'),
                                        'status' => $meta['label'] ?? 'Weekend',
                                        'dot' => $meta['dot'] ?? 'bg-gray-200',
                                        'hours' => $day['hours'] > 0 ? $day['hours'].'h logged' : null,
                                        'time_in' => $day['time_in'],
                                        'time_out' => $day['time_out'],
                                        'location' => $day['location'],
                                        'weather' => $day['weather'],
                                        'altitude' => $day['altitude'],
                                        'late' => $day['late_minutes'] ? $this->formatLateDuration($day['late_minutes']) : null,
                                        'holiday' => $day['holiday_name'] ? $day['holiday_name'].' ('.($holidayMeta[$day['holiday_type']]['label'] ?? 'Holiday').')' : null,
                                    ];
                                    $ringClass = match (true) {
                                        $day['holiday_type'] === 'regular' => 'ring-2 ring-yellow-400 ring-offset-1',
                                        $day['holiday_type'] === 'special' => 'ring-2 ring-cyan-400 ring-offset-1',
                                        (bool) $day['late_minutes'] => 'ring-2 ring-orange-400 ring-offset-1',
                                        default => '',
                                    };
                                @endphp
                                <span class="h-4 w-4 shrink-0 cursor-default rounded-sm transition hover:scale-125 {{ $meta['dot'] ?? 'bg-gray-200' }} {{ $ringClass }}"
                                      @mouseenter="hovered = {{ \Illuminate\Support\Js::from($tooltip) }}" @mouseleave="hovered = null"></span>
                            @endforeach
                        </div>

                        {{-- Hover detail panel --}}
                        <div class="mt-2 min-h-[38px] rounded-xl border border-gray-200 px-3 py-2 text-xs">
                            <template x-if="!hovered">
                                <p class="text-gray-400">Hover a square to see that day's details.</p>
                            </template>
                            <template x-if="hovered">
                                <div class="flex flex-wrap items-center gap-x-4 gap-y-1">
                                    <span class="inline-flex items-center gap-1.5 font-semibold text-gray-800">
                                        <span class="h-2 w-2 rounded-full" :class="hovered.dot"></span>
                                        <span x-text="hovered.date"></span>
                                        <span class="font-normal text-gray-400">·</span>
                                        <span x-text="hovered.status"></span>
                                    </span>
                                    <span x-show="hovered.hours" class="text-gray-500" x-text="hovered.hours"></span>
                                    <span x-show="hovered.time_in" class="text-gray-500">
                                        <span x-text="hovered.time_in"></span> – <span x-text="hovered.time_out"></span>
                                    </span>
                                    <span x-show="hovered.location" class="text-gray-500" x-text="hovered.location"></span>
                                    <span x-show="hovered.weather" class="text-gray-500" x-text="hovered.weather"></span>
                                    <span x-show="hovered.altitude" class="text-gray-500" x-text="hovered.altitude"></span>
                                    <span x-show="hovered.late" class="font-semibold text-orange-600" x-text="hovered.late"></span>
                                    <span x-show="hovered.holiday" class="font-semibold text-yellow-700" x-text="hovered.holiday"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-auto rounded-xl border border-gray-200">
                        <table class="w-full border-collapse text-left text-sm">
                            <thead class="sticky top-0 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-3 py-2">Date</th>
                                    <th class="px-3 py-2">Day</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Time in</th>
                                    <th class="px-3 py-2">Time out</th>
                                    <th class="px-3 py-2">Location</th>
                                    <th class="px-3 py-2">Weather</th>
                                    <th class="px-3 py-2">Altitude</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach (array_reverse($historyDays) as $day)
                                    @php $meta = $statusMeta[$day['status']] ?? null; @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-3 py-2 font-medium text-gray-800">{{ \Carbon\Carbon::parse($day['date'])->format('M j, Y') }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-gray-500">{{ $day['day'] }}</td>
                                        <td class="whitespace-nowrap px-3 py-2">
                                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $meta['chip'] ?? 'bg-gray-100 text-gray-500' }}">
                                                {{ $meta['label'] ?? 'Weekend' }}
                                            </span>
                                            @if ($day['late_minutes'])
                                                <span class="ml-1 inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $lateMeta['chip'] }}">
                                                    {{ $this->formatLateDuration($day['late_minutes']) }}
                                                </span>
                                            @endif
                                            @if ($day['holiday_name'])
                                                <span class="ml-1 inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[11px] font-semibold {{ $holidayMeta[$day['holiday_type']]['chip'] ?? 'bg-gray-100 text-gray-500' }}">
                                                    {{ $day['holiday_name'] }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-2 text-gray-600">{{ $day['time_in'] ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-gray-600">{{ $day['time_out'] ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-gray-600">{{ $day['location'] ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-gray-600">{{ $day['weather'] ?? '—' }}</td>
                                        <td class="whitespace-nowrap px-3 py-2 text-gray-600">{{ $day['altitude'] ?? '—' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Plugins marketplace modal --}}
    @if ($pluginsOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4"
             wire:click="closePlugins" wire:key="plugins-modal">
            <div class="cp-modal w-full max-w-lg overflow-hidden rounded-2xl bg-white shadow-2xl" wire:click.stop>
                <div class="relative border-b border-gray-200 px-4 py-3 text-center">
                    <h3 class="text-base font-bold text-gray-900">Plugins</h3>
                    <button wire:click="closePlugins" type="button"
                            class="absolute right-3 top-1/2 grid h-8 w-8 -translate-y-1/2 place-items-center rounded-full bg-gray-100 text-gray-500 transition hover:bg-gray-200">
                        <x-icon name="x" class="h-5 w-5" />
                    </button>
                </div>

                <div class="max-h-[70vh] overflow-y-auto px-4 py-4">
                    <p class="text-sm text-gray-500">Import plugins to add them as tabs on this company page.</p>

                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        @foreach ($this->pluginManifest() as $key => $plugin)
                            <div class="rounded-xl border border-gray-200 p-3">
                                <div class="flex items-center gap-2">
                                    <div class="grid h-9 w-9 place-items-center rounded-lg bg-blue-50 text-blue-600">
                                        <x-icon name="{{ $plugin['icon'] }}" class="h-5 w-5" />
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $plugin['name'] }}</p>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">{{ $plugin['desc'] }}</p>
                                @if (in_array($key, $installedPlugins, true))
                                    <button type="button" disabled
                                            class="mt-3 w-full cursor-not-allowed rounded-lg bg-gray-100 py-1.5 text-xs font-semibold text-gray-400">
                                        Installed
                                    </button>
                                @else
                                    <button wire:click="importPlugin('{{ $key }}')" type="button"
                                            class="mt-3 w-full rounded-lg bg-blue-600 py-1.5 text-xs font-semibold text-white transition hover:bg-blue-700">
                                        Import
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Fullscreen plugin view --}}
    @if ($fullscreenPlugin)
        <div class="fixed inset-0 z-[60] flex flex-col bg-white" wire:key="fullscreen-plugin">
            <div class="flex items-center justify-between border-b border-gray-200 px-5 py-3">
                <div class="min-w-0">
                    <h3 class="text-base font-bold text-gray-900">{{ ($this->pluginManifest())[$fullscreenPlugin]['name'] ?? 'Plugin' }}</h3>
                    <p class="truncate text-xs text-gray-500">{{ ($this->pluginManifest())[$fullscreenPlugin]['desc'] ?? '' }}</p>
                </div>
                <button wire:click="collapsePlugin" type="button" title="Exit fullscreen"
                        class="grid h-9 w-9 shrink-0 place-items-center rounded-lg border border-gray-300 text-gray-600 transition hover:bg-gray-50">
                    <x-icon name="x" class="h-5 w-5" />
                </button>
            </div>
            <div class="flex-1 overflow-auto p-5">
                @if ($fullscreenPlugin === 'attendance')
                    @include('livewire.company.partials.attendance-table')
                @elseif ($fullscreenPlugin === 'payroll')
                    @include('livewire.company.partials.payroll-table')
                @else
                    <p class="text-sm text-gray-400">This plugin is installed. Content is coming soon.</p>
                @endif
            </div>
        </div>
    @endif

</div>
