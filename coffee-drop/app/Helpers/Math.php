<?php

namespace App\Helpers;

class Math
{
    const EARTH_RADIUS = 6371;

    public static function getSphereDistance(array $pointA, array $pointB)
    {
        $distanceLatitudes = deg2rad($pointB['latitude'] - $pointA['latitude']);
        $distanceLongitudes = deg2rad($pointB['longitude'] - $pointA['longitude']);

        $a = sin($distanceLatitudes / 2) * sin($distanceLatitudes / 2) + cos(deg2rad($pointA['latitude'])) * cos(deg2rad($pointB['latitude'])) * sin($distanceLongitudes / 2) * sin($distanceLongitudes / 2);
        $c = 2 * asin(sqrt($a));

        return round(Math::EARTH_RADIUS * $c, 2);
    }
}
