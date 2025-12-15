<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RentMotorcycleReviewModel;

class RentMotorcycleModel extends Model
{
    use HasFactory;

    protected $table = 'rent_motorcycles';
    
    protected $fillable = [
        'name',
        'price_per_day',
        'url',
        'is_booked'
    ];
    public function reviews()
    {
        return $this->hasMany(RentMotorcycleReviewModel::class, 'rent_motorcycle_id');
    }
}
