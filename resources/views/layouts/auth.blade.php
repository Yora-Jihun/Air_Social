<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Air Social — Sign in</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-white font-sans text-gray-900 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-2">
        <!-- Brand / marketing panel -->
        <aside class="relative hidden overflow-hidden bg-gradient-to-br from-brand to-brand-dark text-white lg:flex lg:flex-col lg:justify-between lg:p-14">
            <div class="text-3xl font-extrabold tracking-tight">Air Social</div>

            <div class="max-w-md">
                <h2 class="text-4xl font-bold leading-tight">
                    Connect with friends and the world around you.
                </h2>
                <p class="mt-5 text-lg text-white/80">
                    Share moments, discover stories, and stay in touch — all in one calm, friendly place.
                </p>

                <ul class="mt-8 space-y-3 text-white/90">
                    <li class="flex items-center gap-3">
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-white/15">✓</span>
                        Secure email verification
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-white/15">✓</span>
                        Fast, password-protected access
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="grid h-8 w-8 place-items-center rounded-full bg-white/15">✓</span>
                        Built for real connections
                    </li>
                </ul>
            </div>

            <div class="text-sm text-white/60">© {{ date('Y') }} Air Social</div>
        </aside>

        <!-- Form panel -->
        <main class="flex min-h-screen items-center justify-center px-6 py-12 lg:min-h-0">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
