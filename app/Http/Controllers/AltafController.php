<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AltafController extends Controller
{
    public function tampilkan()
    {
        return view('event');
    }
}