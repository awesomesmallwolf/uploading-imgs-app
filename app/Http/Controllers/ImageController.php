<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function indeX()
    {
        return view('images.index');
    }
    public function show()
    {
        return Image::latest()->pluck('name')->toArray();
    }
    public function store()
    {
        $file_path =  request()->file('image')->store('public/images');

        if (!$file_path) {
            return response()->json(['error' => "Cannot Upload Images"], 500);
        }

        return Image::create([
            'name' => request()->file('image')->hashName(),
            'extension' => request()->file('image')->extension(),
            'size' => request()->file('image')->getSize()
        ]);
    }
}
