<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Air Social — Where your company connects, works, and grows</title>
    @vite('resources/css/app.css')
    @livewireStyles
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>