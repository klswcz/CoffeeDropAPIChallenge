<?php

namespace Database\Seeders;

use App\Models\BusinessHours;
use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locationsData = array_map('str_getcsv', file('location_data.csv'));

        // Remove headers list
        unset($locationsData[0]);

        foreach ($locationsData as $location) {
            $locationModel = Location::create([
                'postcode' => $location[0]
            ]);

            unset($location[0]);
            $location = array_values($location);

            for ($i = 0; $i <= 6; $i++) {

                BusinessHours::create([
                    'location_id' => $locationModel->id,
                    'day' => $locationModel->getWeekday($i),
                    'opening_time' => $location[$i],
                    'closing_time' => $location[$i + 7]
                ]);
            }
        }
    }
}
