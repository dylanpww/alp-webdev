<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomModel extends Model
{
    use HasFactory;

    protected $table = 'rooms';


    protected $fillable = [
        'room_number',
        'price_per_night',
        'is_booked',
        'description',
        'capacity',
        'type_id',
    ];

    public function type()
    {
        return $this->belongsTo(TypeModel::class);
    }

    public function reservations()
    {
        return $this->hasMany(ReservationModel::class, 'room_id', 'id');
    }
}
