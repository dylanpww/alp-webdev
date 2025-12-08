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
        $room = RoomModel::all();
        return view('room-details', compact('room'));
    }
    public function create()
    {
        $types = TypeModel::all();
        return view('admin_view.create_room', compact('types'));
    }

    public function store(Request $request)
    {
        

        $request->validate([
            'room_number' => 'required|unique:rooms',
            'capacity' => 'required|integer',
            'type_id' => 'required',
            
        ]);

        RoomModel::create([
            'room_number' => $request->room_number,
            'capacity' => $request->capacity,
            'type_id' => $request->type_id
        ]);


        return redirect()->route('rooms.index');
    }
}
