<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoffeePod extends Model
{
    use HasFactory;

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

    public function scopeByName($query, string $name)
    {
        return $query->where('name', $name);
    }

    public static function calculateCashbackValue(array $pods)
    {
        $result = array('total' => 0);

        foreach ($pods as $podName => $amount) {
            $coffeePodModel = CoffeePod::byName($podName)->first();

            switch ($amount) {
                case $amount < 50:
                    $result[$podName] = $amount * $coffeePodModel->value_below_50_items;
                    break;
                case $amount <= 500:
                    $result[$podName] = 49 * $coffeePodModel->value_below_50_items + ($amount - 49) * $coffeePodModel->value_between_50_and_500_items;
                    break;
                case $amount > 500:
                    $result[$podName] = 49 * $coffeePodModel->value_below_50_items + 451 * $coffeePodModel->value_between_50_and_500_items + ($amount - 500) * $coffeePodModel->value_above_500_items;
                    break;
            }
            $result['total'] += $result[$podName];
        }

        return $result;
    }
}
