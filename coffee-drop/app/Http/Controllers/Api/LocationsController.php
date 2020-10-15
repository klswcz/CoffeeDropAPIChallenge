<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessHours;
use App\Models\Location;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PostcodesApi;

class LocationsController extends Controller
{
    public function getNearest($postcode)
    {
        try {
            $userLocation = PostcodesApi::get($postcode);
        } catch (ClientException $e) {
            return response()->json(['message' => 'Passed postcode is not valid.'], 400);
        }

        $nearestLocation = Location::getNearest($userLocation);

        return response()->json([
            'postcode' => $nearestLocation['postcode'],
            'distance' => $nearestLocation['distance'],
            'business_hours' => Location::byPostcode($nearestLocation['postcode'])
                ->first()
                ->getBusinessHours()
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'postcode' => 'required|string|max:255',
            'business_hours' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $location = Location::create([
            'postcode' => str_replace(' ', '', strtoupper($request->get('postcode')))
        ]);

        foreach ($request->get('business_hours') as $day => $businessHours) {
            BusinessHours::create([
                'location_id' => $location->id,
                'day' => strtolower($day),
                'opening_time' => $businessHours['opening_time'],
                'closing_time' => $businessHours['closing_time']
            ]);
        }

        return response()->json([
            'location' => $location,
            'business_hours' => $location->getBusinessHours()
        ]);

    }
}
