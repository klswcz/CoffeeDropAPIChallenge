<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoffeePod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoffeePodsController extends Controller
{
    public function getCashbackAmount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            '*' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $response = CoffeePod::calculateCashbackValue($request->all());

        return response()->json($response);
    }
}
