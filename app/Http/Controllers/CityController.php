<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCityRequest;
use App\Http\Requests\UpdateCityRequest;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{

    /**
     * @api {get} /city city.index
     * @apiName city.index
     * @apiGroup city
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $cities = City::query()
            ->latest()
            ->paginate($request->input('per_page', 10));

        return response()->json($cities);
    }

}
