<?php

namespace App\Http\Controllers;

use App\Models\FacilityModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
{

    public function index()
    {

        $user = Auth::user();
        $username = $user ? $user->name : 'Guest';

        $path = storage_path('app/public/preview');

        $images = collect(File::files($path))
            ->map(function ($file) {
                return 'storage/preview/' . $file->getFilename();
            });

            $facilities = FacilityModel::with("images")->get();


        return view('home', compact('images', 'facilities', 'username'));}

}
