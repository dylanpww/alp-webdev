<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeModel;
use App\Models\RoomModel;

class AvailableRoomController extends Controller
{
    public function search(Request $request)
    {
        $datesRaw = $request->input('dates');

        if (!$datesRaw || !str_contains($datesRaw, ' to ')) {
            return back()->withErrors(['dates' => 'Please select a valid date range.']);
        }

        [$start, $end] = array_map('trim', explode(' to ', $datesRaw));

        $allTypes = TypeModel::with('images')->get();
        $availableTypes = [];

        foreach ($allTypes as $type) {

            $freeRoomsCount = RoomModel::where('type_id', $type->id)
                ->where('is_booked', 0) 
                ->whereDoesntHave('reservations', function ($query) use ($start, $end) {
                    $query->where('status', '!=', 'Cancelled') 
                        ->where(function ($q) use ($start, $end) {
                            $q->where('check_in_date', '<', $end)
                                ->where('check_out_date', '>', $start);
                        });
                })
                ->count();

            if ($freeRoomsCount > 0) {
                $availableTypes[] = [
                    'id'=>$type->id,
                    'type_name'=>$type->name,
                    'price'=>$type->price_per_night,
                    'count'=>$freeRoomsCount,
                    'image'=>$type->images->first()->url ?? 'default.jpg',
                    'description'=>$type->description
                ];
            }
        }

        return view('available-rooms', [
            'types' => $availableTypes,
            'start' => $start,
            'end'   => $end
        ]);
    }
}
