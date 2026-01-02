<?php

namespace App\Http\Controllers;

use App\Models\ReservationModel;
use App\Models\RatingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RatingController extends Controller
{


    public function store(Request $request, $id)
    {

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $hasStayed = ReservationModel::where('user_id', Auth::id())
            ->where(function ($q) {
                $q->where('status', 'Paid')
                    ->orWhere('status', 'settlement')
                    ->orWhere('status', 'capture');
            })
            ->whereHas('room', function ($query) use ($id) {
                $query->where('type_id', $id);
            })
            ->exists();

        if (!$hasStayed) {
            return back()->with('error', 'You must book and pay for this room type to write a review.');
        }

        $alreadyReviewed = RatingModel::where('user_id', Auth::id())
            ->where('type_id', $id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this room.');
        }

        RatingModel::create([
            'user_id' => Auth::id(),
            'type_id' => $id,
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return back();
    }
}
