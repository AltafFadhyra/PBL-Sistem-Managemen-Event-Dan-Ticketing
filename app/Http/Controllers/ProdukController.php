<?php

namespace App\Http\Controllers;

class ProdukController extends Controller
{
    public function getData()
    {
        return [
            ['nama' => 'Tiket Konser', 'harga' => 150000],
            ['nama' => 'Tiket Seminar', 'harga' => 50000],
            ['nama' => 'Tiket Workshop', 'harga' => 100000],
        ];
    }

    public function tampilkan()
    {
        $data = $this->getData();
        return view('produk', compact('data'));
    }
}