<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationModel extends Model
{
    use HasFactory;

    protected $table = 'reservations';


    protected $fillable = [
        "check_in_date",
        "check_out_date",
        "total_price",
        "status",
        "type",
        "user_id",
        "room_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(RoomModel::class, 'room_id', 'id');
    }
}
