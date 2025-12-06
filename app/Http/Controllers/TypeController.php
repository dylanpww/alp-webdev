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
            'images.*' => 'image|max:10000'
        ]);

        $type = TypeModel::create([
            'name' => $request->name,
            'description' => $request->description,
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

        return redirect()->route('types.index')->with('success', 'Type created successfully!');
    }
}
