<?php

namespace App\Http\Controllers;

use App\Models\RoomModel;
use App\Models\RoomImagesModel;
use App\Models\TypeModel;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function index()
    {
        $rooms = RoomModel::all();
        return view('room', compact('rooms'));
    }
    public function create()
    {
        $types = RoomModel::all();
        return view('admin_view.create_room', compact('types'));
    }

    public function store(Request $request)
    {
        

        dd($request->file('images'));

        $request->validate([
            'room_number' => 'required|unique:rooms',
            'price_per_night' => 'required|numeric',
            'capacity' => 'required|integer',
            'type_id' => 'required',
            'description' => 'nullable',
        ]);

        $room = RoomModel::create([
            'room_number' => $request->room_number,
            'price_per_night' => $request->price_per_night,
            'description' => $request->description,
            'capacity' => $request->capacity,
            'type_id' => $request->type_id
        ]);


        return redirect()->route('rooms.index');
    }
}
