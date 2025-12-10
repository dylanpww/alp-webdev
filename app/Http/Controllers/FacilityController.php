<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacilityModel;
use App\Models\FacilityImagesModel;
use Illuminate\Support\Facades\Storage;

class FacilityController extends Controller
{   

    public function index()
    {
        $facilities = FacilityModel::with('images')->get();
        return view('admin_view.facility', compact('facilities'));
    }

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

    public function edit($id)
    {
        $facility = FacilityModel::with('images')->findOrFail($id);
        return view('admin_view.update_facility', compact('facility'));
    }

    public function update(Request $request, $id)
    {
        $facility = FacilityModel::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:facilities,name,' . $facility->id,
            'description' => 'required',
            'images.*' => 'image|max:10000'
        ]);

        $facility->update([
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

    public function destroy($id)
    {
        $facility = FacilityModel::with('images')->findOrFail($id);
        foreach ($facility->images as $img) {
            Storage::disk('public')->delete($img->url);
            $img->delete();
        }

        $facility->delete();

        return redirect()->route('home');
    }
}
