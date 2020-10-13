<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    private $weekdays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    public function businessHours()
    {
        return $this->hasMany(BusinessHours::class);
    }

    public function getWeekday($index)
    {
        return $this->weekdays[$index];
    }
}
