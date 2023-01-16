<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    /**
     * @api {get} /discount discount.index
     * @apiName discount.index
     * @apiGroup discount
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $discount = Discount::query()->where('user_id', auth()->id())->load('products', 'shops')->latest()->paginate($request->input('per_page', 10));
        return response()->json($discount);
    }

    /**
     * @api {post} /discount discount.store
     * @apiName discount.store
     * @apiGroup discount
     * @apiBody {String} code code
     * @apiBody {Date} started_at started_at
     * @apiBody {Date} ended_at ended_at
     * @apiBody {Number} count count
     * @apiBody {Number} value value
     * @apiBody {Number} percent percent
     * @apiBody {Boolean} status  status_consist of amount or percent
     * @apiBody {String} type type_consist true or false
     * @apiBody {Array} product_ids product_ids array of ids
     * @apiBody {Array} shop_ids shop_ids array of ids
     */
    public function store(StoreDiscountRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $discount = Discount::create($request->validated());
        $discount->products()->sync($request->input('products'));
        $discount->shops()->sync($request->input('shops'));
        return response()->json($discount);
    }

    /**
     * @api {get} /discount/:id discount.show
     * @apiName discount.show
     * @apiGroup discount
     * @apiParam {Number} id model id
     */
    public function show(Discount $discount)
    {
        return response()->json($discount);
    }

    /**
     * @api {put} /discount/:id discount.update
     * @apiName discount.update
     * @apiGroup discount
     * @apiBody {String} code code
     * @apiBody {Date} started_at started_at
     * @apiBody {Date} ended_at ended_at
     * @apiBody {Number} count count
     * @apiBody {Number} value value
     * @apiBody {Number} percent percent
     * @apiBody {Boolean} status  status_consist of amount or percent
     * @apiBody {String} type type_consist true or false
     * @apiBody {Array} product_ids product_ids array of ids
     * @apiBody {Array} shop_ids shop_ids array of ids
     * @apiParam {Number} id model id
     */
    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $discount->update($request->validated());
        $discount->products()->sync($request->input('products'));
        $discount->shops()->sync($request->input('shops'));
        return response()->json($discount);
    }

    /**
     * @api {delete} /discount/:id discount.destroy
     * @apiName discount.destroy
     * @apiGroup discount
     * @apiParam {Number} id model id
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response()->json([
            'message' => 'تخفیف با موفقیت حذف شد',
        ]);
    }
}
