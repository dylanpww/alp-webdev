<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacilityModel;
use App\Models\FacilityImagesModel;

class FacilityController extends Controller
{
    public function create()
    {
        return view('admin_view.create_facility');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:facilities,name',
            'description' => 'required',
            'images.*' => 'image|max:10000' 
        ]);

        $facility = FacilityModel::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('facility_images', 'public');

                FacilityImagesModel::create([
                    'facility_id' => $facility->id,
                    'url' => $path
                ]);
            }
        }

        return redirect()->route('home');
    }
}
