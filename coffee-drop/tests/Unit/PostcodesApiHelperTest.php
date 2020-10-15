<?php

namespace Tests\Unit;

use App\Helpers\PostcodesApi;
use App\Models\Location;
use Tests\TestCase;

class PostcodesApiHelperTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function get_location_from_postcodes_api_based_on_postcode()
    {
        $result = PostcodesApi::get('LE1 6RT');

        $this->assertEquals(-1.132275, $result->longitude);
        $this->assertEquals(52.629731, $result->latitude);
    }

    /** @test */
    public function get_bulk_locations_from_postcodes_api_based_on_postcodes()
    {
        $locationA = Location::factory()->create([
            'postcode' => 'LE1 6RT'
        ]);
        $locationB = Location::factory()->create([
            'postcode' => 'LE4 5NS'
        ]);


        $result = PostcodesApi::getLocationsData(collect([$locationA, $locationB]));

        $this->assertEquals(-1.132275, $result[0]->result->longitude);
        $this->assertEquals(-1.132386, $result[1]->result->longitude);
    }

}
