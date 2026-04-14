<!DOCTYPE html>
<html>
<head>
    <title>Produk</title>
</head>
<body>

<h1>Daftar Tiket Event</h1>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Harga</th>
    </tr>

    @foreach($data as $item)
    <tr>
        <td>{{ $item['nama'] }}</td>
        <td>{{ $item['harga'] }}</td>
    </tr>
    @endforeach

</table>

</body>
</html>