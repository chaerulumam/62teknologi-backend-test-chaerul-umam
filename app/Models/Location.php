<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $guareded = 'id';

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
