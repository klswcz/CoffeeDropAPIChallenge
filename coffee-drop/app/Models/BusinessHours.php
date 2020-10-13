<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHours extends Model
{
    protected $table = 'business_hours';

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
