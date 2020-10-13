<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use function GuzzleHttp\json_decode;

class PostcodesApi
{
    public static function get(string $postcode)
    {
        $client = new Client();
        $res = $client->get('https://api.postcodes.io/postcodes/' . $postcode);
        return json_decode($res->getBody()->getContents())->result;
    }

    public static function getBulk(Collection $locations)
    {

        $client = new Client();
        $res = $client->post('https://api.postcodes.io/postcodes/', [
            'json' => [
                'postcodes' => $locations->pluck('postcode')->all()
            ]
        ]);

        return json_decode($res->getBody()->getContents())->result;
    }
}
