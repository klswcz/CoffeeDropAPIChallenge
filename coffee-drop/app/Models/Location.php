<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Math;
use PostcodesApi;

class Location extends Model
{
    use HasFactory;

    private $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
    protected $fillable = ['postcode'];

    public function businessHours()
    {
        return $this->hasMany(BusinessHours::class);
    }

    public function getWeekday($index)
    {
        return $this->weekdays[$index];
    }

    public function scopeByPostcode($query, string $postcode)
    {
        $query->where('postcode', $postcode);
    }

    public static function getNearest($userLocation)
    {
        $userCoordinates = [
            'postcode' => $userLocation->postcode,
            'coordinates' => [
                'latitude' => $userLocation->latitude,
                'longitude' => $userLocation->longitude
            ]
        ];
        $distances = collect(Location::getDistances($userCoordinates));

        return $distances->sortBy('distance')->first();
    }

    public static function getDistances(array $userCoordinates)
    {
        $distances = array();
        foreach (Location::getAllCoordinates() as $location) {
            array_push($distances, [
                'postcode' => $location['postcode'],
                'distance' => Math::getSphereDistance($userCoordinates['coordinates'], $location['coordinates'])
            ]);
        }

        return $distances;
    }

    public static function getAllCoordinates()
    {
        $coordinates = array();
        $locationsData = PostcodesApi::getLocationsData(Location::all());
        foreach ($locationsData as $location) {
            array_push($coordinates, [
                'postcode' => $location->query,
                'coordinates' => [
                    'latitude' => $location->result->latitude,
                    'longitude' => $location->result->longitude
                ]
            ]);
        }

        return $coordinates;
    }
}
