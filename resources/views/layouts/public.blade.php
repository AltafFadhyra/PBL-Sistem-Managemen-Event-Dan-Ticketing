<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Event Ticketing') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Platform pembelian tiket event online terlengkap, tercepat, dan termudah.' }}">
    
    <!-- Open Graph / Social Media -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? config('app.name', 'Event Ticketing') }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Platform pembelian tiket event online terlengkap, tercepat, dan termudah.' }}">
    @if(isset($ogImage))
        <meta property="og:image" content="{{ $ogImage }}">
    @endif
    
    @stack('meta')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mr-8">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                            E
                        </div>
                        <span class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 tracking-tight">Eventix</span>
                    </a>
                    
                    <div class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('tickets.search') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Cek Tiket Saya</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('tickets.search') }}" class="md:hidden text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Cek Tiket</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Dashboard Admin</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-indigo-600 transition">Login Panitia</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-20 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500">
            <p>&copy; {{ date('Y') }} Eventix Ticketing System. All rights reserved.</p>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
