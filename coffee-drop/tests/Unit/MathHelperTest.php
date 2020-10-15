<?php

namespace Tests\Unit;

use App\Helpers\Math;
use Tests\TestCase;

class MathHelperTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function calculate_distance_between_two_points()
    {
        $pointA = [
            'latitude' => 52.629731,
            'longitude' => -1.132275
        ];
        $pointB = [
            'latitude' => 52.653654,
            'longitude' => -1.132386
        ];

        $result = Math::getSphereDistance($pointA, $pointB);

        $this->assertEquals(2.66, $result);
    }
}
