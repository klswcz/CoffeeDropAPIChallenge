<?php

namespace Tests\Feature;

use App\Models\CoffeePod;
use Tests\TestCase;

class CoffeePodsTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function get_coffee_pods_cashback_amount()
    {
        $coffeeA = CoffeePod::factory()->create([
            'name' => 'coffeeA',
            'value_below_50_items' => 3,
            'value_between_50_and_500_items' => 4,
            'value_above_500_items' => 6
        ]);
        $coffeeB = CoffeePod::factory()->create([
            'name' => 'coffeeB',
            'value_below_50_items' => 1,
            'value_between_50_and_500_items' => 3,
            'value_above_500_items' => 7
        ]);

        $query = [
            "coffeeA" => 10,
            "coffeeB" => 100,
        ];

        $this->post('api/pods/cashback/calculate', $query)->assertSessionHasNoErrors()
            ->assertStatus(200)
            ->assertJson([
                'total' => 232,
                'coffeeA' => 30,
                'coffeeB' => 202
            ]);
    }
}
