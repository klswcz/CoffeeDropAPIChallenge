<?php

namespace Database\Factories;

use App\Models\CoffeePod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CoffeePodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CoffeePod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'value_below_50_items' => $this->faker->numberBetween(1, 4),
            'value_between_50_and_500_items' => $this->faker->numberBetween(5, 7),
            'value_above_500_items' => $this->faker->numberBetween(8, 10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
