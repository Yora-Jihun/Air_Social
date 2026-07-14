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
    <div class="pb-20 lg:pb-0">
        {{ $slot }}
    </div>

    <x-bottom-nav />

    @livewireScripts
</body>
</html>