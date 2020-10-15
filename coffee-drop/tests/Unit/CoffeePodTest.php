<?php

namespace Tests\Unit;

use App\Models\CoffeePod;
use Tests\TestCase;

class CoffeePodTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function calculate_cashback_value_for_small_amount_of_pods()
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
        $requestArray = [
            $coffeeA->name => 10,
            $coffeeB->name => 5
        ];
        $expected = [
            'total' => 35,
            $coffeeA->name => 30,
            $coffeeB->name => 5
        ];

        $result = CoffeePod::calculateCashbackValue($requestArray);

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function calculate_cashback_value_for_medium_amount_of_pods()
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
        $requestArray = [
            $coffeeA->name => 70,
            $coffeeB->name => 5
        ];
        $expected = [
            'total' => 236,
            $coffeeA->name => 231,
            $coffeeB->name => 5
        ];

        $result = CoffeePod::calculateCashbackValue($requestArray);

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function calculate_cashback_value_for_large_amount_of_pods()
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
        $requestArray = [
            $coffeeA->name => 600,
            $coffeeB->name => 5
        ];
        $expected = [
            'total' => 2556,
            $coffeeA->name => 2551,
            $coffeeB->name => 5
        ];

        $result = CoffeePod::calculateCashbackValue($requestArray);

        $this->assertEquals($expected, $result);
    }

    /** @test */
    public function return_total_value_of_0_when_empty_array_passed()
    {
        $coffeeA = CoffeePod::factory()->create([
            'name' => 'coffeeA',
            'value_below_50_items' => 3,
            'value_between_50_and_500_items' => 4,
            'value_above_500_items' => 6
        ]);
        $requestArray = [];
        $expected = [
            'total' => 0,
        ];

        $result = CoffeePod::calculateCashbackValue($requestArray);

        $this->assertEquals($expected, $result);
    }

}
