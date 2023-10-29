<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $guareded = 'id';

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function location()
    {
        return $this->hasOne(Location::class);
    }
}
