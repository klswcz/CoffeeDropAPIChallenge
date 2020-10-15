<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashbackQueries as CashbackQueriesResourceCollection;
use App\Models\CashbackQuery;
use App\Models\CoffeePod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function GuzzleHttp\json_encode;

class CoffeePodsController extends Controller
{
    public function getCashbackAmount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => [
                'nullable',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    if (!CoffeePod::byName($attribute)->exists()) {
                        return $fail($attribute . ' is not a valid coffee pod name.');
                    }
                }
            ],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $response = CoffeePod::calculateCashbackValue($request->all());
        $response = $this->convertToPounds($response);
        CashbackQuery::create([
            'query' => json_encode($request->all()),
            'result' => json_encode($response)
        ]);

        return response()->json($response);
    }

    public function getLatestQueries()
    {

        $cashbackQueriesResourceCollection = new CashbackQueriesResourceCollection(CashbackQuery::orderBy('created_at',
            'desc')->limit(5)->get());

        return response()->json($cashbackQueriesResourceCollection);
    }

    protected function convertToPounds(array $response)
    {
        foreach ($response as $key => $amount) {
            $response[$key] = money_format('%n', $amount / 100);
        }

        return $response;
    }
}
