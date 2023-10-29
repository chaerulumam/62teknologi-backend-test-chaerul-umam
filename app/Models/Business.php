<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    // protected $guareded = 'id';

    protected $fillable = [
        'name', 'alias', 'image_url', 'is_closed', 'url',
        'review_count', 'transactions', 'rating', 'latitude',
        'longitude', 'price', 'phone', 'display_phone', 'distance'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }
}
