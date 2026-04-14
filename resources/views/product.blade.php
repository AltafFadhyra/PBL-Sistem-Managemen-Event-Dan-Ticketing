@extends('layout')

@section('content')

<h1>Daftar Event & Tiket</h1>

<p>
Berikut adalah beberapa event yang tersedia beserta harga tiket yang dapat dipesan melalui sistem ini.
</p>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama Event</th>
        <th>Kategori</th>
        <th>Tanggal</th>
        <th>Harga Tiket</th>
    </tr>

    <tr>
        <td>Konser Musik Nasional</td>
        <td>Konser</td>
        <td>20 Mei 2026</td>
        <td>Rp 150.000</td>
    </tr>

    <tr>
        <td>Seminar Teknologi</td>
        <td>Seminar</td>
        <td>5 Juni 2026</td>
        <td>Rp 50.000</td>
    </tr>

    <tr>
        <td>Workshop Desain Grafis</td>
        <td>Workshop</td>
        <td>15 Juni 2026</td>
        <td>Rp 100.000</td>
    </tr>

</table>

<br>

<h3>Informasi Tambahan:</h3>
<ul>
    <li>Tiket dapat dibeli secara online</li>
    <li>Pembayaran dilakukan melalui sistem digital</li>
    <li>E-ticket akan dikirim setelah pembayaran berhasil</li>
</ul>

@endsection