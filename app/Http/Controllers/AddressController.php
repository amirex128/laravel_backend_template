<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AddressController extends Controller
{
    /**
     * @api {get} /address address.index
     * @apiName address.index
     * @apiGroup address
     * @apiHeader {String} Authorization token
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $addresses = Address::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate($request->input('per_page', 10));

        return response()->json($addresses);
    }


    /**
     * @api {post} /address address.store
     * @apiName address.store
     * @apiGroup address
     * @apiBody {String} name
     * @apiBody {String} address
     * @apiBody {String} title
     * @apiBody {String} address
     * @apiBody {Number} postal_code
     * @apiBody {Number} mobile
     * @apiBody {String} full_name
     * @apiBody {Number} lat
     * @apiBody {Number} long
     * @apiBody {Number} city_id
     * @apiBody {Number} province_id
     * @apiHeader {String} Authorization token
     */
    public function store(StoreAddressRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $address = Address::query()->create($request->validated());

        return response()->json($address);
    }

    /**
     * @api {get} /address/:id address.show
     * @apiName address.show
     * @apiParam {Number} id model id
     * @apiGroup address
     * @apiHeader {String} Authorization token
     */
    public function show(Address $address)
    {
        return response()->json($address);
    }

    /**
     * @api {post} /address/:id address.update
     * @apiName address.update
     * @apiGroup address
     * @apiHeader {String} Authorization token
     * @apiParam {Number} id model id
     * @apiBody {String} name
     * @apiBody {String} address
     * @apiBody {String} title
     * @apiBody {String} address
     * @apiBody {Number} postal_code
     * @apiBody {Number} mobile
     * @apiBody {String} full_name
     * @apiBody {Number} lat
     * @apiBody {Number} long
     * @apiBody {Number} city_id
     * @apiBody {Number} province_id
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        return response()->json($address);
    }

    /**
     * @api {delete} /address/:id address.destroy
     * @apiName address.destroy
     * @apiParam {Number} id model id
     * @apiGroup address
     * @apiHeader {String} Authorization token
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return response()->json([
            'message' => 'آدرس با موفقیت حذف شد',
        ]);
    }
}
