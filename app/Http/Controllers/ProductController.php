<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $id = 1;
        $produk = "Laptop";

        return view('list_product', compact('id', 'produk'));
    }
}