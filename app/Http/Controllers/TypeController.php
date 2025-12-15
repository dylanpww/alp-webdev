<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ReservationModel;
use App\Models\TypeModel;
use App\Models\TypeImagesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TypeController extends Controller
{
    public function index()
    {
        $types = TypeModel::all();
        return view('admin_view.type', compact('types'));
    }

    public function book()
    {
        $types = TypeModel::with('images')->get();
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
            'images.*' => 'image|max:20480'
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
        $canReview = false;
        $alreadyReviewed = false;
        $averageRating = $type->reviews->avg('rating') ?? 0;

        if (Auth::check()) {
            $hasStayed = ReservationModel::where('user_id', Auth::id())
                ->where(function ($q) {
                    $q->where('status', 'Paid')
                        ->orWhere('status', 'paid')
                        ->orWhere('status', 'settlement')
                        ->orWhere('status', 'capture');
                })
                ->whereHas('room', function ($query) use ($id) {
                    $query->where('type_id', $id);
                })
                ->exists();

            $alreadyReviewed = $type->reviews()->where('user_id', Auth::id())->exists();

            if ($hasStayed && !$alreadyReviewed) {
                $canReview = true;
            }
        }
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
            'room' => $roomData,
            'canReview' => $canReview,
            'alreadyReviewed' => $alreadyReviewed
        ]);
    }
    public function edit($id)
    {
        $type = TypeModel::with('images')->findOrFail($id);

        return view('admin_view.update_type', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $type = TypeModel::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:types,name,' . $type->id,
            'description' => 'nullable',
            'price_per_night' => 'required|numeric',
            'images.*' => 'image|max:20480'
        ]);

        $type->update([
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

        return redirect()->route('types.index')->with('success', 'Room Type updated successfully!');
    }
    public function destroy($id)
    {
        $facility = TypeModel::with('images')->findOrFail($id);
        foreach ($facility->images as $img) {
            Storage::disk('public')->delete($img->url);
            $img->delete();
        }

        $facility->delete();

        return redirect()->route('home');
    }
}
