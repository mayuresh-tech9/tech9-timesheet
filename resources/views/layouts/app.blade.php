<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Timesheet</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
{{--    <script src="https://cdn.tailwindcss.com"></script>--}}
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="antialiased">
<div class="menu-wrapper">
    <nav class="flex flex-wrap items-center justify-evenly p-4 bg-blue-950 text-white">
        <!-- Add your menu items here -->
        <a href="{{route('logs')}}" class="flex items-center">Logs</a>
        <a href="{{route('settings')}}" class="flex items-center">Settings</a>
        <!-- Add more menu items as needed -->
    </nav>
</div>
{{$slot}}
@livewireScripts
</body>
</html>
