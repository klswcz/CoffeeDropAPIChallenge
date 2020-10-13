<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoffeePod extends Model
{
    protected $table = 'coffee_pods';

    public function getLowQuantityValue()
    {
        return $this->value_below_50_items;
    }

    public function getMediumQuantityValue()
    {
        return $this->value_between_50_and_500_items;
    }

    public function getHighQuantityValue()
    {
        return $this->value_above_500_items;
    }
}
