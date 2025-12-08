<?php

namespace App\Http\Controllers;

use App\Models\TypeModel;
use App\Models\TypeImagesModel;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $types = TypeModel::all();
        return view('book', compact('types'));
    }

    public function create()
    {
        return view('admin_view.create_type');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:types,name',
            'description' => 'nullable',
            'price_per_night' => 'required|numeric',
            'images.*' => 'image|max:10000'
        ]);

        $type = TypeModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
        ]);

        if ($request->hasFile('images')) {

            $folderName = 'type_images/' . str_replace(' ', '_', strtolower($type->name));

            foreach ($request->file('images') as $img) {
                $path = $img->store($folderName, 'public');
                TypeImagesModel::create([
                    'type_id' => $type->id,
                    'url' => $path
                ]);
            }
        }

        return redirect()->route('types.index');
    }

    public function show($id)
    {
        $type = TypeModel::with(['reviews.user', 'images'])->findOrFail($id);
        $averageRating = $type->reviews->avg('rating') ?? 0;

        $roomData = (object) [
            'id' => $type->id,
            'type_name' => $type->name,
            'price' => $type->price_per_night,
            'image' => $type->images->first() ? $type->images->first()->url : 'default.jpg',
            'description' => $type->description,
            'average_rating' => $averageRating,
            'reviews' => $type->reviews 
        ];

        return view('room-details', [
            'room' => $roomData
        ]);
    }
}
