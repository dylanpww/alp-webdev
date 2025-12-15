<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservationModel;
use App\Models\PaymentModel;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function midtransCallback()
    {
        try {
            // 1. Config
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            // 2. Receive Notification
            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id; // e.g., "RES-15-17384..."
            $grossAmount = $notification->gross_amount;

            // --- CRASH PREVENTION START ---
            // If Order ID doesn't have a dash '-', this line used to crash your app
            $orderParts = explode('-', $orderId);

            // Check if we successfully got the ID (index 1)
            if (!isset($orderParts[1])) {
                return response()->json(['message' => 'Invalid Order ID format'], 400);
            }

            $reservationId = $orderParts[1];
            // --- CRASH PREVENTION END ---

            // 3. Find Reservation
            $reservation = ReservationModel::find($reservationId);

            if (!$reservation) {
                return response()->json(['message' => 'Reservation not found'], 404);
            }

            // 4. Determine Method Name
            $methodName = $type;
            if ($type == 'credit_card') $methodName = 'Credit Card';
            elseif ($type == 'bank_transfer') $methodName = 'Bank Transfer';
            elseif ($type == 'echannel') $methodName = 'Mandiri Bill';
            elseif ($type == 'gopay') $methodName = 'GoPay';
            elseif ($type == 'shopeepay') $methodName = 'ShopeePay';
            elseif ($type == 'qris') $methodName = 'QRIS';

            // 5. Update Status
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($notification->fraud_status == 'challenge') {
                        $reservation->update(['status' => 'Pending']);
                    } else {
                        $this->markAsPaid($reservation, $grossAmount, $methodName);
                    }
                }
            } else if ($transaction == 'settlement') {
                $this->markAsPaid($reservation, $grossAmount, $methodName);
            } else if ($transaction == 'pending') {
                $reservation->update(['status' => 'Pending']);
            } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
                $reservation->update(['status' => 'Cancelled']);
            }

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $e) {
            // This writes the specific error to storage/logs/laravel.log
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    private function markAsPaid($reservation, $amount, $method)
    {
        $reservation->update(['status' => 'Paid']);

        $exists = PaymentModel::where('reservation_id', $reservation->id)->exists();

        if (!$exists) {
            PaymentModel::create([
                'reservation_id' => $reservation->id,
                'amount'         => $amount,
                'payment_method' => $method,
                'status'         => 'Paid'
            ]);
        }
    }
}
