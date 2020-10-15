<?php

namespace Database\Factories;

use App\Models\BusinessHours;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessHoursFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BusinessHours::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'day' => strtolower($this->faker->dayOfWeek()),
            'opening_time' => $this->faker->time($format = 'H:i'),
            'closing_time' => $this->faker->time($format = 'H:i'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
