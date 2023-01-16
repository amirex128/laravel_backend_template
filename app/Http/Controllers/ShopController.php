<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    /**
     * @api {get} /shop shop.index
     * @apiName shop.index
     * @apiGroup shop
     * @apiHeader {String} Authorization token
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        $shops = Shop::query()
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate($request->input('per_page'), 10);
        return response()->json($shops);
    }

    /**
     * @api {post} /shop shop.store
     * @apiName shop.store
     * @apiGroup shop
     * @apiHeader {String} Authorization token
     * @apiBody {String} name name
     * @apiBody {String} description description
     * @apiBody {Number} phone phone
     * @apiBody {Number} mobile mobile
     * @apiBody {String} telegram_id telegram_id
     * @apiBody {String} instagram_id instagram_id
     * @apiBody {String} whatsapp_id whatsapp_id
     * @apiBody {String} email email
     * @apiBody {String} website website
     * @apiBody {Number} send_price send_price
     * @apiBody {String} type type
     * @apiBody {Number} gallery_id gallery_id
     * @apiBody {Number} theme_id theme_id
     */
    public function store(StoreShopRequest $request)
    {
        $request->merge(['user_id' => auth()->id()]);
        $shop = Shop::create($request->validated());
        return response()->json($shop);
    }

    /**
     * @api {get} /shop/{shop} shop.show
     * @apiName shop.show
     * @apiGroup shop
     * @apiHeader {String} Authorization token
     */
    public function show(Shop $shop)
    {
        return response()->json($shop);
    }


    /**
     * @api {put} /shop/{shop} shop.update
     * @apiName shop.update
     * @apiGroup shop
     * @apiHeader {String} Authorization token
     * @apiBody {String} name name
     * @apiBody {String} description description
     * @apiBody {Number} phone phone
     * @apiBody {Number} mobile mobile
     * @apiBody {String} telegram_id telegram_id
     * @apiBody {String} instagram_id instagram_id
     * @apiBody {String} whatsapp_id whatsapp_id
     * @apiBody {String} email email
     * @apiBody {String} website website
     * @apiBody {Number} send_price send_price
     * @apiBody {String} type type
     * @apiBody {Number} gallery_id gallery_id
     * @apiBody {Number} theme_id theme_id
     */
    public function update(UpdateShopRequest $request, Shop $shop)
    {
        $shop->update($request->validated());
        return response()->json($shop);
    }

    /**
     * @api {delete} /shop/{shop} shop.destroy
     * @apiName shop.destroy
     * @apiGroup shop
     * @apiHeader {String} Authorization token
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();
        return response()->json([
            'message' => 'فروشگاه با موفقیت حذف شد',
        ]);
    }
}
