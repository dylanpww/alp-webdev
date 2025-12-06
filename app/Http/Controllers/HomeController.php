<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $path = storage_path('app/public/preview');

        $images = collect(File::files($path))
            ->map(function ($file) {
                return 'storage/preview/' . $file->getFilename();
            });

        return view('home', compact('images'));
    }
}
