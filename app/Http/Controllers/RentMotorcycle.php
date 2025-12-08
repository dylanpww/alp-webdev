<?php

namespace App\Http\Controllers;

use App\Models\RentMotorcycleModel;
use Illuminate\Http\Request;

class RentMotorcycle extends Controller
{
    public function index()
    {
        $rents = RentMotorcycleModel::all();
        return view('rent-motorcycle', compact('rents'));
    }

    public function create()
    {
        return view('admin_view.create_rental');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rent_motorcycles,name',
            'price_per_day' => 'required|numeric',
            'images.*' => 'image|max:10000'
        ]);

        
        $rent = RentMotorcycleModel::create([
            'name' => $request->name,
            'price_per_day' => $request->price_per_day,
        ]);

        
        if ($request->hasFile('images')) {

            $img = $request->file('images'); 
            $path = $img->store('motorcycle_images', 'public');

            $rent->update([
                'url' => $path
            ]);
        }

        return redirect()->route('rents.index');
    }

}
