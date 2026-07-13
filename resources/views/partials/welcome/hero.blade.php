<div class="max-w-3xl mx-auto text-center px-6 py-24">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white shadow-lg shadow-blue-200 mb-8">
        <x-icon name="trending-up" class="w-8 h-8" />
    </div>

    <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 mb-4">Welcome to Air Social</h1>

    <p class="text-lg text-gray-500 mb-10 max-w-xl mx-auto">
        The social workspace for your whole company &mdash; connect, share, and collaborate all in one place.
    </p>

    <div class="flex flex-col sm:flex-row justify-center gap-4">
        <x-button :href="route('register')" variant="primary">Get Started</x-button>
        <x-button :href="route('login')" variant="secondary">Log In</x-button>
    </div>
</div>
