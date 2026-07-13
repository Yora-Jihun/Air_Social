@if ($show)
    <x-card>
        <div class="p-5 text-center">
            <div class="mx-auto grid h-12 w-12 place-items-center rounded-full bg-blue-50 text-blue-600">
                <x-icon name="building" class="h-6 w-6" />
            </div>
            <h3 class="mt-3 font-semibold text-gray-900">Create your own company</h3>
            <p class="mx-auto mt-1 max-w-sm text-sm text-gray-500">
                Start a company on Air Social to post updates, build groups, and bring your team together.
            </p>
            <a href="#"
               class="mt-4 inline-flex items-center justify-center gap-1.5 rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                <x-icon name="plus" class="h-4 w-4" />
                Create your company
            </a>
        </div>
    </x-card>
@endif
