<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservationModel;
use App\Models\PaymentModel;
use Midtrans\Config;
use Midtrans\Notification;

class CallbackController extends Controller
{
    public function midtransCallback()
    {
        try {
            
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $orderId = $notification->order_id; 
            $grossAmount = $notification->gross_amount;

            $orderParts = explode('-', $orderId);
            if (!isset($orderParts[1])) {
                return response()->json(['message' => 'Invalid Order ID format'], 400);
            }

            $reservationId = $orderParts[1];
            $reservation = ReservationModel::find($reservationId);

            if (!$reservation) {
                return response()->json(['message' => 'Reservation not found'], 404);
            }

            $methodName = $type;
            if ($type == 'credit_card') $methodName = 'Credit Card';
            elseif ($type == 'bank_transfer') $methodName = 'Bank Transfer';
            elseif ($type == 'echannel') $methodName = 'Mandiri Bill';
            elseif ($type == 'gopay') $methodName = 'GoPay';
            elseif ($type == 'shopeepay') $methodName = 'ShopeePay';
            elseif ($type == 'qris') $methodName = 'QRIS';

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
