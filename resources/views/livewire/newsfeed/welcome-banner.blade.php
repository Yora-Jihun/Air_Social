<div x-data="{ dismissed: false }" x-show="! dismissed" x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 -translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="relative overflow-hidden rounded-xl bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-600 p-6 text-white shadow-xl ring-1 ring-white/10 sm:p-10 sm:min-h-[170px]">
    <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-white/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-20 -left-12 h-48 w-48 rounded-full bg-indigo-300/20 blur-3xl"></div>

    <button type="button" @click="dismissed = true" aria-label="Dismiss"
            class="absolute right-4 top-4 grid h-9 w-9 place-items-center rounded-full text-white/70 transition hover:bg-white/15 hover:text-white">
        <x-icon name="x" class="h-5 w-5" />
    </button>

    <div class="relative flex flex-col gap-6">
        <div class="max-w-md pr-10">
            <h2 class="text-2xl font-bold leading-tight sm:text-3xl">Welcome, {{ $name }}!</h2>
            <p class="mt-2 text-sm text-blue-100 sm:text-base">
                You're all set. Explore companies or start your own to begin posting with your team.
            </p>
        </div>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
            <a href="#"
               class="inline-flex items-center justify-center rounded-xl bg-white/15 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-white/25">
                Explore companies
            </a>
            <a href="#"
               class="inline-flex items-center justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-blue-700 shadow-sm transition hover:bg-blue-50">
                Create your company
            </a>
        </div>
    </div>
</div>
