<?php

namespace App\Http\Controllers;

use App\Models\RentMotorcycleModel;
use App\Models\RentMotorcycleReviewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RentMotorcycle extends Controller
{

    public function rent()
    {
        $rents = RentMotorcycleModel::all();
        return view('rent-motorcycle', compact('rents'));
    }

    public function search(Request $request)
    {
        $dateRange = $request->input('dates');
        $rents = [];
        $start = null;
        $end = null;

        if ($dateRange) {
            $dates = explode(' to ', $dateRange);
            
            if (count($dates) == 2) {
                $start = $dates[0];
                $end = $dates[1];
                
                $rents = RentMotorcycleModel::all(); 
                
                return view('available-motorcycle', compact('rents', 'start', 'end'));
            } else {
                return redirect()->back()->with('error', 'Please select a valid date range.');
            }
        } 

        return redirect()->route('rents.rent');
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $motor = RentMotorcycleModel::findOrFail($id);

        RentMotorcycleReviewModel::create([
            'user_id' => Auth::id(),
            'rent_motorcycle_id' => $motor->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully!');
    }

    public function index()
    {
        $rents = RentMotorcycleModel::all();
        return view('admin_view.rental', compact('rents'));
    }

    public function create()
    {
        return view('admin_view.create_rental');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:rent_motorcycles,name',
            'price_per_day' => 'required|numeric',
            'images' => 'nullable'
        ]);

        $rent = RentMotorcycleModel::create([
            'name' => $request->name,
            'price_per_day' => $request->price_per_day,
            'url' => null
        ]);

        if ($request->hasFile('images')) {
            $file = $request->file('images');
            if (is_array($file)) { $file = $file[0]; }
            $path = $file->store('motorcycle_images', 'public');
            $rent->update(['url' => $path]);
        }

        return redirect()->route('rents.index');
    }
    public function edit($id)
    {
        $rent = RentMotorcycleModel::findOrFail($id);
        
        return view('admin_view.update_rental', compact('rent'));
    }

    public function update(Request $request, $id)
    {
        $rent = RentMotorcycleModel::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:rent_motorcycles,name,' . $rent->id,
            'price_per_day' => 'required|numeric',
            'images' => 'nullable'
        ]);

        $rent->update([
            'name' => $request->name,
            'price_per_day' => $request->price_per_day,
        ]);

        if ($request->hasFile('images')) {
            
            if ($rent->url && Storage::disk('public')->exists($rent->url)) {
                Storage::disk('public')->delete($rent->url);
            }

            $file = $request->file('images');
            if (is_array($file)) { $file = $file[0]; }
            
            $path = $file->store('motorcycle_images', 'public');

            $rent->update(['url' => $path]);
        }

        return redirect()->route('rents.index')->with('success', 'Motorcycle updated successfully!');
    }

    public function destroy($id)
    {
        $rent = RentMotorcycleModel::findOrFail($id);

        if ($rent->url && Storage::disk('public')->exists($rent->url)) {
            Storage::disk('public')->delete($rent->url);
        }

        $rent->delete();

        return redirect()->route('rents.index')->with('success', 'Motorcycle deleted successfully!');
    }
}