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
     * @apiHeader {String} Authorization token
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $cities = City::query()
            ->get();

        return response()->json($cities);
    }

}
