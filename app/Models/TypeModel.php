<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RoomModel;

class TypeModel extends Model
{
    use HasFactory;

    protected $table = 'types';
    protected $fillable = [
        'name',
        'description',
        'price_per_night',
    ];

    public function rooms()
    {
        return $this->hasMany(RoomModel::class, 'type_id');
    }

    public function reviews()
    {
        
        return $this->hasMany(RatingModel::class, 'type_id');
    }

    public function images()
    {
        return $this->hasMany(TypeImagesModel::class, 'type_id', 'id');
    }
}
