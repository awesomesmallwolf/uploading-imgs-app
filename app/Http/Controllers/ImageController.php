<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function indeX()
    {
        return view('images.index');
    }
}
