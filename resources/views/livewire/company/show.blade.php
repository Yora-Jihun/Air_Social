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
                        <h3 class="text-sm font-semibold text-gray-900">Attendance</h3>
                        <p class="mt-1 text-sm text-gray-500">Manage attendance · preview</p>

                        <div class="mt-4 max-h-[70vh] overflow-auto rounded-xl border border-gray-200">
                            <table class="w-full border-collapse text-left text-sm">
                                <thead class="sticky top-0 bg-gray-50 text-xs font-semibold uppercase tracking-wide text-gray-500">
                                    <tr>
                                        <th class="px-4 py-2.5">Photo</th>
                                        <th class="px-4 py-2.5">Date</th>
                                        <th class="px-4 py-2.5">Time</th>
                                        <th class="px-4 py-2.5">Location</th>
                                        <th class="px-4 py-2.5">Coordinate</th>
                                        <th class="px-4 py-2.5">Weather</th>
                                        <th class="px-4 py-2.5">Altitude</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach ($attendanceRecords as $rec)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2.5">
                                                <x-avatar :src="$rec['avatar'] ?? null" :name="$rec['name']" size="sm" />
                                            </td>
                                            <td class="whitespace-nowrap px-4 py-2.5 font-medium text-gray-800">{{ $rec['date'] }}</td>
                                            <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">{{ $rec['time'] }}</td>
                                            <td class="px-4 py-2.5 text-gray-600">{{ $rec['location'] }}</td>
                                            <td class="whitespace-nowrap px-4 py-2.5 font-mono text-xs text-gray-500">{{ $rec['coordinate'] }}</td>
                                            <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">{{ $rec['weather'] }}</td>
                                            <td class="whitespace-nowrap px-4 py-2.5 text-gray-600">{{ $rec['altitude'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

</div>
