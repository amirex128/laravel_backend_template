<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    /**
     * @api {get} /product product.index
     * @apiName product.index
     * @apiGroup product
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate($request->input('per_page'), 10);
        return response()->json($products);
    }


    /**
     * @api {post} /product product.store
     * @apiName product.store
     * @apiGroup product
     * @apiBody {String} name name
     * @apiBody {String} description description
     * @apiBody {Number} quantity quantity
     * @apiBody {Number} price price
     * @apiBody {Number} shop_id shop_id
     */
    public function store(StoreProductRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $product = Product::create($request->validated());
        return response()->json($product);
    }

    /**
     * @api {get} /product/{product} product.show
     * @apiName product.show
     * @apiGroup product
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }


    /**
     * @api {put} /product/{product} product.update
     * @apiName product.update
     * @apiGroup product
     * @apiBody {String} name name
     * @apiBody {String} description description
     * @apiBody {Number} quantity quantity
     * @apiBody {Number} price price
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'message' => 'محصول با موفقیت حذف شد',
        ]);
    }
}
