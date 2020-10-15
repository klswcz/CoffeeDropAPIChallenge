<?php

namespace Tests\Feature;

use App\Models\BusinessHours;
use App\Models\Location;
use Tests\TestCase;

class LocationsTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function get_nearest_location()
    {
        $nearestLocation = Location::factory()->create([
            'postcode' => 'E7 8PN'
        ]);

        $businessHoursMonday = BusinessHours::factory()->create([
            'location_id' => $nearestLocation->id,
            'day' => 'monday'
        ]);
        $businessHoursTuesday = BusinessHours::factory()->create([
            'location_id' => $nearestLocation->id,
            'day' => 'tuesday'
        ]);


        $this->get('/api/location/nearest/E61AJ')
            ->assertSessionHasNoErrors()
            ->assertStatus(200)
            ->assertJson([
                'postcode' => $nearestLocation->postcode,
                'distance' => 0.43,
                'business_hours' => [
                    [
                        "day" => $businessHoursMonday->day,
                        "opening_time" => $businessHoursMonday->opening_time,
                        "closing_time" => $businessHoursMonday->closing_time
                    ],
                    [
                        "day" => $businessHoursTuesday->day,
                        "opening_time" => $businessHoursTuesday->opening_time,
                        "closing_time" => $businessHoursTuesday->closing_time
                    ]
                ]
            ]);
    }

    /** @test */
    public function create_new_location()
    {
        $this->post('api/location/create', [
            'postcode' => 'LE2 7TR',
            'business_hours' => [
                'monday' => [
                    'opening_time' => '10:00',
                    'closing_time' => '20:00'
                ],
                'tuesday' => [
                    'opening_time' => '12:30',
                    'closing_time' => '17:15'
                ]
            ],
        ])->assertSessionHasNoErrors()
            ->assertStatus(200)
            ->assertJson([
                'location' => [
                    'postcode' => Location::byPostcode('LE27TR')->first()->postcode,
                ],
                'business_hours' => [
                    [
                        'day' => 'monday',
                        'opening_time' => '10:00',
                        'closing_time' => '20:00'
                    ],
                    [
                        'day' => 'tuesday',
                        'opening_time' => '12:30',
                        'closing_time' => '17:15'
                    ]
                ]
            ]);

        $this->assertDatabaseHas('locations', [
            'postcode' => 'LE27TR',
        ]);
        $this->assertDatabaseHas('business_hours', [
            'location_id' => Location::byPostcode('LE27TR')->first()->id,
            'day' => 'monday',
            'opening_time' => '10:00',
            'closing_time' => '20:00'
        ]);
        $this->assertDatabaseHas('business_hours', [
            'location_id' => Location::byPostcode('LE27TR')->first()->id,
            'day' => 'tuesday',
            'opening_time' => '12:30',
            'closing_time' => '17:15'
        ]);

    }
}
