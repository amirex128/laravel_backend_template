<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{


    /**
     * @api {get} /option option.index
     * @apiName option.index
     * @apiGroup option
     */
    public function index(Request $request,Product $product)
    {
        $options = Option::query()
            ->where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->oldest()
            ->get();
        return response()->json($options);
    }


    /**
     * @api {post} /option option.store
     * @apiName option.store
     * @apiGroup option
     * @apiBody {String} name name
     * @apiBody {Number} price price
     * @apiBody {Number} quantity quantity
     * @apiBody {Number} product_id product_id
     */
    public function store(StoreOptionRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $option = Option::create($request->validated());
        return response()->json($option);
    }

    /**
     * @api {put} /option/{option} option.update
     * @apiName option.update
     * @apiGroup option
     * @apiBody {String} name name
     * @apiBody {Number} price price
     * @apiBody {Number} quantity quantity
     */
    public function update(UpdateOptionRequest $request, Option $option)
    {
        $option->update($request->validated());
        return response()->json($option);
    }

    /**
     * @api {delete} /option/{option} option.destroy
     * @apiName option.destroy
     * @apiGroup option
     */
    public function destroy(Option $option)
    {
        $option->delete();
        return response()->json([
            'message' => 'تنوع با موفقیت حذف شد',
        ]);
    }
}
