<?php

namespace Tests\Unit;

use App\Helpers\PostcodesApi;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LocationTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function get_nearest_location()
    {
        $userPostcode = 'LE1 6RT';

        $locationA = Location::factory()->create([
           'postcode' => 'LE4 5NS'
        ]);
        $locationB = Location::factory()->create([
            'postcode' => 'NG2 4BE'
        ]);
        $expected = [
          'postcode' => $locationA->postcode,
          'distance' => 2.66
        ];

        $result = Location::getNearest(PostcodesApi::get($userPostcode));

        $this->assertEquals($expected, $result);
    }
}
