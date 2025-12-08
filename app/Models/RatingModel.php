<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingModel extends Model
{
    use HasFactory;
    protected $table = 'ratings';

    protected $fillable = [
        'user_id',
        'type_id', 
        'rating',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }

    public function type()
    {
        return $this->belongsTo(TypeModel::class, 'type_id');
    }
}
