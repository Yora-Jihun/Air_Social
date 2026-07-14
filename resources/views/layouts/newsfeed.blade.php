<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Air Social — News Feed</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="{{ request()->routeIs('messages.index') ? 'lg:pb-0' : 'pb-20 lg:pb-0' }}">
        {{ $slot }}
    </div>

    @unless (request()->routeIs('messages.index'))
        <x-bottom-nav />
    @endunless

    @livewireScripts
</body>
</html>