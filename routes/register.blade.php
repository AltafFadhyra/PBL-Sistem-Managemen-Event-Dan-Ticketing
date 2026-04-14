@extends('layout')

@section('content')
<h2 class="text-3xl font-bold mb-4">Register</h2>

<div class="bg-white p-6 rounded shadow max-w-md">
    <input type="text" placeholder="Nama" class="border p-2 w-full mb-3">
    <input type="text" placeholder="Email" class="border p-2 w-full mb-3">
    <input type="password" placeholder="Password" class="border p-2 w-full mb-3">

    <button class="bg-green-600 text-white px-5 py-2 rounded w-full">
        Daftar
    </button>
</div>
@endsection