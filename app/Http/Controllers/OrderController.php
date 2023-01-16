<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    /**
     * @api {get} /customer/order customer.order.index
     * @apiName customer.order.index
     * @apiGroup customer.order
     * @apiHeader {String} Authorization token
     * @apiParam {type} status status_consist of (new, pending, finished,returned)
     * @apiParam {Number} [per_page=10] per page
     */
    public function customerIndex(Request $request)
    {
        if ($request->input('status') === 'new') {
            $orders = Order::query()
                ->where('customer_id', auth()->id())
                ->whereIn('status', ['wait_for_pay', 'wait_for_try_pay', 'paid'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        } elseif ($request->input('status') === 'pending') {
            $orders = Order::query()
                ->where('customer_id', auth()->id())
                ->whereIn('status', ['wait_for_sender', 'wait_for_delivery'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        } elseif ($request->input('status') === 'finished') {
            $orders = Order::query()
                ->where('customer_id', auth()->id())
                ->whereIn('status', ['delivered', 'returned_paid', 'returned_timeout'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        } elseif ($request->input('status') === 'returned') {
            $orders = Order::query()
                ->where('customer_id', auth()->id())
                ->whereIn('status', ['wait_for_accept_returned', 'reject_returned', 'wait_for_sender_returned', 'delivered_returned', 'wait_for_returned_pay_back'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        }

        return response()->json($orders);
    }

    /**
     * @api {get} /order order.index
     * @apiName order.index
     * @apiGroup order
     * @apiHeader {String} Authorization token
     * @apiParam {Number} [per_page=10] per page
     */
    public function index(Request $request)
    {
        if ($request->input('status') === 'new') {
            $orders = Order::query()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['wait_for_pay', 'wait_for_try_pay', 'paid'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        } elseif ($request->input('status') === 'pending') {
            $orders = Order::query()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['wait_for_sender', 'wait_for_delivery'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        } elseif ($request->input('status') === 'finished') {
            $orders = Order::query()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['delivered', 'returned_paid', 'returned_timeout'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        } elseif ($request->input('status') === 'returned') {
            $orders = Order::query()
                ->where('user_id', auth()->id())
                ->whereIn('status', ['wait_for_accept_returned', 'reject_returned', 'wait_for_sender_returned', 'delivered_returned', 'wait_for_returned_pay_back'])
                ->latest()
                ->paginate($request->input('per_page', 10));
        }

        return response()->json($orders);
    }

    /**
     * @api {post} /order order.store
     * @apiName order.store
     * @apiGroup order
     * @apiHeader {String} Authorization token
     */
    public function store(StoreOrderRequest $request)
    {
        $shop = Shop::query()->findOrFail($request->input('shop_id'));
        $customer = auth()->user();
        $discount = Discount::query()->findOrFail($request->input('discount_id'));
        $order_items = $request->input('order_items');

        if (empty($discount->started_at) && $discount->end_at < now()) {
            return response()->json(['message' => 'کد تخفیف منقضی شده است'], 422);
        }
        if (empty($discount->ended_at) && $discount->started_at > now()) {
            return response()->json(['message' => 'کد تخفیف هنوز شروع نشده است'], 422);
        }
        if ($discount->start_at > now() || $discount->end_at < now()) {
            return response()->json(['message' => 'کد تخفیف منقضی شده است'], 422);
        }

        foreach ($order_items as $key => $order_item) {
            $order_items[$key]['product'] = Product::query()->findOrFail($order_item['product_id']);
            if ($order_item->stock < $order_item['quantity']) {
                return response()->json(['message' => 'موجودی کالا کافی نیست'], 422);
            }
        }

        $order = Order::create($request->validated());
        return response()->json($order, 201);
    }

    /**
     * @api {post} /customer/order customer.order.store
     * @apiName customer.order.store
     * @apiGroup customer.order
     * @apiHeader {String} Authorization token
     */
    public function customerStore(StoreOrderRequest $request)
    {
        $shop = Shop::query()->findOrFail($request->input('shop_id'));
        $customer = auth()->user();
        $orderItems = collect($request->input('order_items'));
        $order = new Order();

        $discount = '';
        $discountProducts = '';
        $calculatedProductPrice = collect([]);

        if ($request->filled('discount_id')) {
            $discount = Discount::query()->findOrFail($request->input('discount_id'));
            if (empty($discount->started_at) && $discount->end_at < now()) {
                return response()->json(['message' => 'کد تخفیف منقضی شده است'], 422);
            }
            if (empty($discount->ended_at) && $discount->started_at > now()) {
                return response()->json(['message' => 'کد تخفیف هنوز شروع نشده است'], 422);
            }
            if ($discount->start_at > now() || $discount->end_at < now()) {
                return response()->json(['message' => 'کد تخفیف منقضی شده است'], 422);
            }
            if ($discount->model === 'shop') {
                $discountProducts = $discount->shops()->with('products')->get();

            } elseif ($discount->model === 'product') {
                $discountProducts = $discount->products()->get();
            }

        }

        foreach ($orderItems as $key => $orderItem) {
            $orderItems[$key]['product'] = Product::query()->findOrFail($orderItem['product_id']);
            if ($orderItems[$key]['product']->quantity < $orderItem['quantity']) {
                return response()->json(['message' => 'موجودی کالا کافی نیست'], 422);
            }
            if ($orderItems[$key]['product']->shop_id !== $shop->id) {
                return response()->json(['message' => 'کالا متعلق به فروشگاه مورد نظر نیست'], 422);
            }
            if (!$orderItems[$key]['product']->active) {
                return response()->json(['message' => 'کالا فعال نیست'], 422);
            }
            if ($orderItems[$key]['product']->block_status !== 'ok') {
                return response()->json(['message' => 'کالا مسدود شده است'], 422);
            }
            if ($orderItems[$key]['product']->deleted_at !== null) {
                return response()->json(['message' => 'کالا حذف شده است'], 422);
            }

            if (empty($discountProducts)) {
                $calculatedProductPrice->push([
                    'product_id' => $orderItems[$key]['product']->id,
                    'raw_price' => $orderItems[$key]['product']->price,
                    'raw_price_count' => $orderItems[$key]['product']->price * $orderItems[$key]['quantity'],
                    'percent' => 0,
                    'off_price' => 0,
                    'new_price' => $orderItems[$key]['product']->price * $orderItems[$key]['quantity'],
                    'quantity' => $orderItems[$key]['quantity'],
                ]);
            } else {
                if ($discountProducts->contains(fn($value, $key) => $value->id === $orderItems[$key]['product']->id)) {
                    if ($discount->type === 'percent') {
                        $calculatedProductPrice->push([
                            'product_id' => $orderItems[$key]['product']->id,
                            'raw_price' => $orderItems[$key]['product']->price,
                            'raw_price_count' => $orderItems[$key]['product']->price * $orderItems[$key]['quantity'],
                            'percent' => $discount->percent,
                            'off_price' => ($orderItems[$key]['product']->price * $orderItems[$key]['quantity']) * ($discount->percent / 100),
                            'new_price' => ($orderItems[$key]['product']->price * $orderItems[$key]['quantity']) - (($orderItems[$key]['product']->price * $orderItems[$key]['quantity']) * ($discount->percent / 100)),
                            'quantity' => $orderItems[$key]['quantity'],
                        ]);
                    } else {
                        $calculatedProductPrice->push([
                            'product_id' => $orderItems[$key]['product']->id,
                            'raw_price' => $orderItems[$key]['product']->price,
                            'raw_price_count' => $orderItems[$key]['product']->price * $orderItems[$key]['quantity'],
                            'amount' => $discount->amount,
                            'off_price' => $discount->amount,
                            'new_price' => $orderItems[$key]['product']->price * $orderItems[$key]['quantity'] - $discount->amount,
                            'quantity' => $orderItems[$key]['quantity'],
                        ]);
                    }
                }
            }
        }

        foreach ($calculatedProductPrice as $key => $calculatedProduct) {
            $order->total_product_price += $calculatedProduct['raw_price_count'];
            $order->total_discount_price += $calculatedProduct['off_price'];
            $order->total_tax_price += $calculatedProduct['new_price'] * ($shop->tax / 100);
            $order->total_product_discount_price += $calculatedProduct['new_price'];
        }
        $order->total_final_price = $order->total_product_discount_price + $order->total_tax_price + $shop->send_price;
        $order->send_price = $shop->send_price;
        $order->tax = $shop->tax;
        $order->user_id = $shop->user_id;
        $order->shop_id = $shop->id;
        $order->discount_id = $discount->id ?? null;
        $order->customer_id = $customer->id;
        $order->ip = $request->ip();
        $order->status = 'wait_for_pay';
        $order->description = $request->description;
        $order->last_update_status_at = now();
        $order->save();

        $orderItems->map(function ($value) use ($order) {
            return [
                'product_id' => $value['product_id'],
                'option_id' => $value['option_id'],
                'quantity' => $value['quantity'],
                'order_id' => $order->id,
            ];
        });

        OrderItem::query()->insert($orderItems->toArray());
        return response()->json($order, 201);
    }

    /**
     * @api {get} /order/:id order.show
     * @apiName order.show
     * @apiGroup order
     * @apiParam {Number} id model id
     * @apiHeader {String} Authorization token
     */
    public function show(Order $order)
    {
        return response()->json($order);
    }

    /**
     * @api {get} /customer/order/:id order.show
     * @apiName customer.order.show
     * @apiGroup customer.order
     * @apiParam {Number} id model id
     * @apiHeader {String} Authorization token
     */
    public function customerShow(Order $order)
    {
        return response()->json($order);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateOrderRequest $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
