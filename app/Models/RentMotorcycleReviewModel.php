<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentMotorcycleReviewModel extends Model
{
    use HasFactory;

    protected $table = 'rent_motorcycle_reviews'; // Nama tabel yang baru dibuat

    protected $fillable = [
        'user_id',
        'rent_motorcycle_id',
        'rating',
        'comment'
    ];

    // Relasi ke User (Siapa yang review)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Motor (Motor apa yang direview)
    public function motorcycle()
    {
        return $this->belongsTo(RentMotorcycleModel::class, 'rent_motorcycle_id');
    }
}