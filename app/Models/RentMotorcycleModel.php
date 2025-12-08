<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentMotorcycleModel extends Model
{
    use HasFactory;

    protected $table = 'rent_motorcycles';
    
    protected $fillable = [
        'name',
        'price_per_day',
        'url',
    ];
}
