<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityImagesModel extends Model
{
   use HasFactory;

    protected $table = 'facility_images';

    protected $fillable = [
        'facility_id',
        'url'
    ];

    public function facility()
    {
        return $this->belongsTo(FacilityModel::class);
    }

}
