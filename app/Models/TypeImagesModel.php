<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeImagesModel extends Model
{
    use HasFactory;

    protected $table = 'type_images';

    protected $fillable = [
        'type_id',
        'url',
    ];

    public function type()
    {
        return $this->belongsTo(TypeModel::class, 'type_id', 'id');
    }
}
