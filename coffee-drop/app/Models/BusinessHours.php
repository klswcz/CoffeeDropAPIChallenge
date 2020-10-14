<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessHours extends Model
{
    protected $table = 'business_hours';
    protected $fillable = ['location_id', 'day', 'opening_time', 'closing_time'];
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
