<?php

namespace Tests\Feature;

use App\Http\Resources\BusinessHours as BusinessHoursResourceCollection;
use App\Http\Resources\Location as LocationResource;
use App\Models\BusinessHours;
use App\Models\Location;
use Tests\TestCase;
use function GuzzleHttp\json_encode;

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


        $response = $this->get('/api/location/nearest/E61AJ')
            ->assertSessionHasNoErrors()
            ->assertStatus(200);

        $this->assertEquals(
            json_encode([
                'postcode' => $nearestLocation->postcode,
                'distance' => 0.43,
                'business_hours' => new BusinessHoursResourceCollection($nearestLocation->businessHours)
            ]), $response->getContent()
        );
    }

    /** @test */
    public function create_new_location()
    {
        $response = $this->post('api/location/create', [
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
            ->assertStatus(200);

        $this->assertEquals(json_encode([
            'location' => new LocationResource(Location::byPostcode('LE27TR')->first()),
            'business_hours' => new BusinessHoursResourceCollection(Location::byPostcode('LE27TR')->first()->businessHours)
        ]), $response->getContent());

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
