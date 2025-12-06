<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoomModel;

class ReservationCOntroller extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'dates' => 'required'
        ]);

        // "2025-12-10 to 2025-12-12"
        $dates = explode(" to ", $request->dates);

        $check_in = $dates[0] ?? null;
        $check_out = $dates[1] ?? null;

        if (!$check_in || !$check_out) {
            return back()->with('error', 'Please select both dates.');
        }


        $availableRooms = RoomModel::whereDoesntHave('reservations', function ($q) use ($check_in, $check_out) {
            $q->where(function ($q2) use ($check_in, $check_out) {
                $q2->whereBetween('check_in', [$check_in, $check_out])
                    ->orWhereBetween('check_out', [$check_in, $check_out])
                    ->orWhere(function ($q3) use ($check_in, $check_out) {
                        $q3->where('check_in', '<=', $check_in)
                            ->where('check_out', '>=', $check_out);
                    });
            });
        })->get();

        return view('available-rooms', compact('availableRooms', 'check_in', 'check_out'));
    }
}
