<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{

    /**
     * @api {get} /province province.index
     * @apiName province.index
     * @apiGroup province
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $province = Province::query()->get();
        return response()->json($province);
    }

}
