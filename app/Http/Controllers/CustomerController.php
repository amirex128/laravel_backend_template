<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{


    /**
     * @api {get} /customer customer.index
     * @apiName customer.index
     * @apiGroup customer
     * @apiHeader {String} Authorization token
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $customer = Customer::query()->latest()->paginate($request->input('per_page', 10));
        return response()->json($customer);
    }


    /**
     * @api {get} /customer/:id customer.show
     * @apiName customer.show
     * @apiGroup customer
     * @apiHeader {String} Authorization token
     * @apiParam {Number} id model id
     */
    public function show(Customer $customer)
    {
        return response()->json($customer);
    }


    /**
     * @api {put} /customer/:id customer.update
     * @apiName customer.update
     * @apiGroup customer
     * @apiHeader {String} Authorization token
     * @apiBody {String} full_name full_name
     * @apiBody {Number} mobile mobile
     * @apiBody {String} address address
     * @apiBody {Number} postal_code postal_code
     * @apiBody {Number} city_id city_id
     * @apiBody {Number} province_id province_id
     * @apiParam {Number} id model id
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return response()->json($customer);
    }

}
