<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    use HasFactory;
    protected $table = 'payments';

    protected $fillable = [
        'reservation_id',
        'amount',
        'payment_method',
        'status',

    ];

    public function reservation()
    {
        return $this->belongsTo(ReservationModel::class, 'reservation_id');
    }
}
