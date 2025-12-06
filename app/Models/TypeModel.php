<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeModel extends Model
{
    use HasFactory;

    protected $table = 'types';
    protected $fillable = [
        'name',
        'description',
    ];

    public function rooms()
    {
        return $this->hasMany(RoomModel::class);
    }

    public function images()
    {
        return $this->hasMany(TypeImagesModel::class, 'type_id', 'id');
    }
}
