<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessHours extends Model
{
    protected $table = 'business_hours';

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getBusinessHoursJsonAttribute()
    {
        return [
            'day' => $this->day,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time
        ];
    }
}
