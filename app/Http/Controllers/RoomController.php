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
        $today = date('Y-m-d');
        $rooms = RoomModel::with(['type', 'reservations' => function ($query) use ($today) {
            $query->where('status', '!=', 'Cancelled') 
                ->where('check_in_date', '<=', $today) 
                ->where('check_out_date', '>', $today);
        }])->get();
        return view('admin_view.room', compact('rooms'));
    }
    public function room()
    {
        $rooms = TypeModel::with('images')->get();
        return view('room-details', compact('types'));
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
    public function edit($id)
    {
        $room = RoomModel::findOrFail($id);
        $types = TypeModel::all();

        return view('admin_view.update_room', compact('room', 'types'));
    }

    public function update(Request $request, $id)
    {
        $room = RoomModel::findOrFail($id);

        $request->validate([
            'room_number' => 'required|unique:rooms,room_number,' . $room->id,
            'type_id' => 'required|exists:types,id',
            'is_booked' => 'required|boolean'
        ]);

        $room->update([
            'room_number' => $request->room_number,
            'type_id' => $request->type_id,
            'is_booked' => $request->is_booked,
        ]);

        return redirect()->route('rooms.index');
    }

    public function destroy($id)
    {
        $room = RoomModel::findOrFail($id);
        $room->delete();

        return redirect()->route('rooms.index');
    }
}
