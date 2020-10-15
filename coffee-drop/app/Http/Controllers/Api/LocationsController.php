<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BusinessHours as BusinessHoursResourceCollection;
use App\Http\Resources\Location as LocationResource;
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

        $businessHoursResourceCollection = new BusinessHoursResourceCollection(Location::byPostcode($nearestLocation['postcode'])
            ->first()
            ->businessHours
        );


        return response()->json([
            'postcode' => $nearestLocation['postcode'],
            'distance' => $nearestLocation['distance'],
            'business_hours' => $businessHoursResourceCollection
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
            'location' => new LocationResource($location),
            'business_hours' => new BusinessHoursResourceCollection($location->businessHours)
        ]);

    }
}
