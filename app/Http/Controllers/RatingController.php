<?php

namespace App\Http\Controllers;

use App\Models\RatingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RatingController extends Controller
{
    public function index()
    {
        $rooms = RatingModel::all();
        return view('room-details', compact('rooms'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        RatingModel::create([
            'user_id' => Auth::id(), 
            'type_id' => $id,       
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return back();
    }
}
