<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'My App')</title>
    <style>
        .container { width: 80%; margin: auto; }
    </style>
</head>
<body>
    @include('layouts.header')

    <div class="container">
        <h1>List Produk</h1>
        <main>
            @yield('content')
        </main>
    </div>

    @include('layouts.footer')
</body>
</html>