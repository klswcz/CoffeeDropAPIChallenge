<?php

namespace Database\Seeders;

use App\Models\CoffeePod;
use Illuminate\Database\Seeder;

class CoffeePodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CoffeePod::firstOrCreate([
            'name' => 'Ristretto',
            'value_below_50_items' => 2,
            'value_between_50_and_500_items' => 3,
            'value_above_500_items' => 5
        ]);

        CoffeePod::firstOrCreate([
            'name' => 'Espresso',
            'value_below_50_items' => 4,
            'value_between_50_and_500_items' => 6,
            'value_above_500_items' => 10
        ]);

        CoffeePod::firstOrCreate([
            'name' => 'Lungo',
            'value_below_50_items' => 6,
            'value_between_50_and_500_items' => 9,
            'value_above_500_items' => 15
        ]);

    }
}
