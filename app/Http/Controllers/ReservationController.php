<?php

namespace App\Http\Controllers;

use App\Models\RentMotorcycleModel;
use Illuminate\Http\Request;
use App\Models\RoomModel;
use App\Models\TypeModel;
use App\Models\ReservationModel;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class ReservationController extends Controller
{

    public function showAll(Request $request)
    {
        $reservations = ReservationModel::with(['user', 'room.type', 'rental'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $reservations->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($subQuery) use ($search) {
                        $subQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('email', 'LIKE', "%{$search}%");
                    });
            });
        }

        $reservations = $reservations->get();
        return view("admin_view.reservations", compact('reservations'));
    }

    public function createRoom(Request $request)
    {
        $request->validate([
            'type_id'    => 'required|exists:types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $typeId = $request->input('type_id');
        $start  = $request->input('start_date');
        $end    = $request->input('end_date');

        $type = TypeModel::findOrFail($typeId);

        $days = (strtotime($end) - strtotime($start)) / (60 * 60 * 24);
        $totalPrice = $type->price_per_night * $days;

        return view('payment', [
            'type'        => $type,
            'start_date'  => $start,
            'end_date'    => $end,
            'days'        => $days,
            'total_price' => $totalPrice
        ]);
    }
    public function storeRoom(Request $request)
    {
        $request->validate([
            'type_id'        => 'required|exists:types,id',
            'check_in_date'  => 'required|date',
            'check_out_date' => 'required|date',
            'total_price'    => 'required|numeric',
        ]);

        $start = $request->check_in_date;
        $end   = $request->check_out_date;

        $randomRoom = RoomModel::where('type_id', $request->type_id)
            ->where('is_booked', 0)
            ->whereDoesntHave('reservations', function ($query) use ($start, $end) {
                $query->where('status', '!=', 'Cancelled')
                    ->where(function ($q) use ($start, $end) {

                        $q->where('check_in_date', '<', $end)
                            ->where('check_out_date', '>', $start);
                    });
            })
            ->inRandomOrder()
            ->first();

        $reservation = ReservationModel::create([
            'user_id' => Auth::id(),
            'room_id' => $randomRoom->id,
            'check_in_date' => $start,
            'check_out_date' => $end,
            'total_price' => $request->total_price,
            'status' => 'Pending',
            'type' => 'Hotel',
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => 'RES-' . $reservation->id . '-' . time(),
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment-midtrans', compact('snapToken', 'reservation'));
    }

    public function createRental(Request $request)
    {
        $request->validate([
            'rental_id'  => 'required|exists:rent_motorcycles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $rental = RentMotorcycleModel::findOrFail($request->rental_id);

        $days = (strtotime($request->end_date) - strtotime($request->start_date)) / (60 * 60 * 24);
        $totalPrice = $rental->price_per_day * $days;

        return view('payment', [
            'rental'      => $rental,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'days'        => $days,
            'total_price' => $totalPrice,
            'is_rental'   => true
        ]);
    }


    public function storeRental(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rent_motorcycles,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date',
            'total_price' => 'required|numeric',
        ]);
        $reservation = ReservationModel::create([
            'user_id' => Auth::id(),
            'room_id' => null,
            'rental_id' => $request->rental_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $request->total_price,
            'status' => 'Pending',
            'type' => 'Rental',
        ]);

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => 'RENTAL-' . $reservation->id . '-' . time(),
                'gross_amount' => (int) $request->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];
        $snapToken = Snap::getSnapToken($params);
        return view('payment-midtrans', compact('snapToken', 'reservation'));
    }
}
