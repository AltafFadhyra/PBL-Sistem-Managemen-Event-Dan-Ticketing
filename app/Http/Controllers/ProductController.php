<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Menyiapkan data berupa id dan produk
        $data = [
            ['id' => 1, 'produk' => 'Laptop Gaming'],
            ['id' => 2, 'produk' => 'Mouse Wireless'],
            ['id' => 3, 'produk' => 'Keyboard Mechanical'],
        ];

        // Merujuk ke view (resource/views/list_product.blade.php) 
        // dan mengirimkan variabel $data
        return view('list_product', compact('data'));
    }
}