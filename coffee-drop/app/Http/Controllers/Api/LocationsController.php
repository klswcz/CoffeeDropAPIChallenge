<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use PostcodesApi;

class LocationsController extends Controller
{
    public function getNearest($postcode)
    {
        $userLocation = PostcodesApi::get($postcode);

        $nearestLocation = Location::getNearest($userLocation);

        return response()->json([
            'postcode' => $nearestLocation['postcode'],
            'distance' => $nearestLocation['distance'],
            'business_hours' => Location::byPostcode($nearestLocation['postcode'])
                ->first()
                ->getBusinessHours()
        ]);
    }

    public function create(string $postcode, $openingTimes)
    {
        return 0;
    }
}
