<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityModel extends Model
{
    use HasFactory;

    protected $table = 'facilities';

    protected $fillable = [
        "name",
        "description",
    ];

    public function images()
    {
        return $this->hasMany(FacilityImagesModel::class, 'facility_id');
    }
}
