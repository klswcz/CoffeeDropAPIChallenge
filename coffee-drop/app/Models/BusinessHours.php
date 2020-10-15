<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHours extends Model
{
    use HasFactory;

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
            'closing_time' => $this->closing_time,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
