<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Event Ticketing' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto flex justify-between items-center p-4">
        <h1 class="text-xl font-bold">🎟️ Event Ticketing</h1>

        <div class="space-x-4">
            <a href="/" class="hover:text-yellow-300">Home</a>
            <a href="/about" class="hover:text-yellow-300">About</a>
            <a href="/product" class="hover:text-yellow-300">Product</a>
            <a href="/contact" class="hover:text-yellow-300">Contact</a>
        </div>
    </div>
</nav>

<div class="container mx-auto p-6">
    @yield('content')
</div>

</body>
</html>