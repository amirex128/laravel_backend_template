<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Discount;
use App\Models\Option;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
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
     * @api {post} /customer/order customer.order.store
     * @apiName customer.order.store
     * @apiGroup customer.order
     * @apiBody {Number} shop_id shop_id
     * @apiBody {Number} discount_id discount_id
     * @apiBody {Array} order_items order_items
     * @apiBody {Number} order_items.product_id product_id
     * @apiBody {Number} order_items.quantity quantity
     * @apiBody {Number} order_items.option_id option_id
     * @apiHeader {String} Authorization token
     */
    public function submitOrder(StoreOrderRequest $request)
    {
        $shop = Shop::query()->findOrFail($request->input('shop_id'));
        $customer = auth()->user();
        $orderItems = $request->input('order_items');
        $order = new Order();

        $discount = '';
        $discountProducts = '';
        $calculatedProductPrice = collect([]);

        if ($request->filled('discount_id')) {
            $discount = Discount::query()->findOrFail($request->input('discount_id'));
            if (Order::query()->where('customer_id', $customer->id)->where('discount_id', $discount->id)->exists()) {
                return response()->json(['message' => 'شما قبلا از این کد تخفیف استفاده کرده اید'], 422);
            }
            if ($discount->count === 0) {
                return response()->json(['message' => 'کد تخفیف شما به پایان رسیده است'], 422);
            }
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
                return response()->json([
                    'message' => sprintf("موجودی محصول %s کافی نمیباشد", $orderItems[$key]['product']->name),
                ], 422);
            }
            if ($orderItems[$key]['product']->shop_id !== $shop->id) {
                return response()->json([
                    'message' => sprintf("محصول %s متعلق به این فروشگاه نمیباشد", $orderItems[$key]['product']->name),
                ], 422);
            }
            if (!$orderItems[$key]['product']->active) {
                return response()->json([
                    'message' => sprintf("محصول %s فعال نمیباشد", $orderItems[$key]['product']->name),
                ], 422);
            }
            if ($orderItems[$key]['product']->block_status !== 'ok') {
                return response()->json([
                    'message' => sprintf('محصول %s مسدود میباشد', $orderItems[$key]['product']->name),
                ], 422);
            }
            if ($orderItems[$key]['product']->deleted_at !== null) {
                return response()->json(['message' => 'کالا حذف شده است'], 422);
            }

            if (array_key_exists('option_id', $orderItem) && $orderItem['option_id'] !== 0) {
                $option = Option::query()->where('product_id', $orderItem['product_id'])->where('id', $orderItem['option_id'])->firstOrFail();
            } else {
                $option = null;
            }

            $hasOption = $option !== null;
            if (empty($discountProducts)) {
                $newPrice = $orderItems[$key]['product']->price * $orderItems[$key]['quantity'];
                $newPriceOption = $hasOption ? $option->price * $orderItems[$key]['quantity'] : 0;

                $rawPriceCount = $orderItems[$key]['product']->price * $orderItems[$key]['quantity'];
                $rawPriceCountOption = $hasOption ? $option->price * $orderItems[$key]['quantity'] : 0;
                $calculatedProductPrice->push([
                    'product_id' => $orderItems[$key]['product']->id,
                    'option_id' => $hasOption ? $option->id : null,
                    'quantity' => $orderItems[$key]['quantity'],
                    'raw_price' => $orderItems[$key]['product']->price,
                    'raw_price_option' => $option->price ?? 0,
                    'raw_price_count' => $rawPriceCount,
                    'raw_price_option_count' => $rawPriceCountOption,
                    'amount' => 0,
                    'percent' => 0,
                    'off_price' => 0,
                    'off_price_option' => 0,
                    'new_price' => $newPrice,
                    'new_price_option' => $newPriceOption,
                    'final_raw_price' => $hasOption ? $rawPriceCountOption : $rawPriceCount,
                    'final_price' => $hasOption ? $newPriceOption : $newPrice,
                    'has_option' => $hasOption
                ]);
            } else {
                if ($discountProducts->contains(fn($value, $key) => $value->id === $orderItems[$key]['product']->id)) {
                    if ($discount->type === 'percent') {
                        $newPrice = ($orderItems[$key]['product']->price * $orderItems[$key]['quantity']) - (($orderItems[$key]['product']->price * $orderItems[$key]['quantity']) * ($discount->percent / 100));
                        $newPriceOption = $hasOption ? ($option->price * $orderItems[$key]['quantity']) - (($option->price * $orderItems[$key]['quantity']) * ($discount->percent / 100)) : 0;
                        $rawPriceCount = $orderItems[$key]['product']->price * $orderItems[$key]['quantity'];
                        $rawPriceCountOption = $hasOption ? $option->price * $orderItems[$key]['quantity'] : 0;
                        $calculatedProductPrice->push([
                            'product_id' => $orderItems[$key]['product']->id,
                            'option_id' => $hasOption ? $option->id : null,
                            'quantity' => $orderItems[$key]['quantity'],
                            'raw_price' => $orderItems[$key]['product']->price,
                            'raw_price_option' => $option->price ?? 0,
                            'raw_price_count' => $rawPriceCount,
                            'raw_price_option_count' => $rawPriceCountOption,
                            'amount' => $discount->amount,
                            'percent' => $discount->percent,
                            'off_price' => ($orderItems[$key]['product']->price * $orderItems[$key]['quantity']) * ($discount->percent / 100),
                            'off_price_option' => ($option->price * $orderItems[$key]['quantity']) * ($discount->percent / 100),
                            'new_price' => $newPrice,
                            'new_price_option' => $newPriceOption,
                            'final_raw_price' => $hasOption ? $rawPriceCountOption : $rawPriceCount,
                            'final_price' => $hasOption ? $newPriceOption : $newPrice,
                            'has_option' => $hasOption
                        ]);
                    } else {
                        $newPrice = $orderItems[$key]['product']->price * $orderItems[$key]['quantity'] - $discount->amount;
                        $newPriceOption = $hasOption ? $option->price * $orderItems[$key]['quantity'] - $discount->amount : 0;

                        $rawPriceCount = $orderItems[$key]['product']->price * $orderItems[$key]['quantity'];
                        $rawPriceCountOption = $hasOption ? $option->price * $orderItems[$key]['quantity'] : 0;

                        $calculatedProductPrice->push([
                            'product_id' => $orderItems[$key]['product']->id,
                            'option_id' => $hasOption ? $option->id : null,
                            'quantity' => $orderItems[$key]['quantity'],
                            'raw_price' => $orderItems[$key]['product']->price,
                            'raw_price_option' => $option->price ?? 0,
                            'raw_price_count' => $rawPriceCount,
                            'raw_price_option_count' => $rawPriceCountOption,
                            'amount' => $discount->amount,
                            'percent' => $discount->percent,
                            'off_price' => $discount->amount,
                            'off_price_option' => $discount->amount,
                            'new_price' => $newPrice,
                            'new_price_option' => $newPriceOption,
                            'final_raw_price' => $hasOption ? $rawPriceCountOption : $rawPriceCount,
                            'final_price' => $hasOption ? $newPriceOption : $newPrice,
                            'has_option' => $hasOption
                        ]);
                    }
                }
            }
        }

        foreach ($calculatedProductPrice as $key => $calculatedProduct) {
            $order->total_product_price += $calculatedProduct['final_raw_price'];
            $order->total_discount_price += $calculatedProduct['off_price'];
            $order->total_tax_price += $calculatedProduct['final_price'] * ($shop->tax / 100);
            $order->total_product_discount_price += $calculatedProduct['final_price'];
        }

        $order->total_final_price = $order->total_product_discount_price + $order->total_tax_price + $shop->send_price;

        $order->send_price = $shop->send_price;
        $order->tax = $shop->tax;
        $order->user_id = $shop->user_id;
        $order->shop_id = $shop->id;
        $order->discount_id = $discount->id ?? null;
        $order->customer_id = $customer->id;
        $order->ip = $request->ip();
        if (auth()->user() instanceof User) {
            if ($request->input('status') === 'paid') {
                $order->status = 'paid';
            } elseif ($request->input('status') === 'wait_for_pay') {
                $order->status = 'wait_for_pay';
            } else {
                $order->status = 'wait_for_pay';
            }
        } else {
            $order->status = 'wait_for_pay';
        }
        $order->description = $request->input('description');
        $order->last_update_status_at = now();
        $order->save();

        foreach ($calculatedProductPrice as $key => $calculatedProduct) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $calculatedProduct['product_id'];
            $orderItem->option_id = $calculatedProduct['option_id'];
            $orderItem->quantity = $calculatedProduct['quantity'];
            $orderItem->raw_price = $calculatedProduct['raw_price'];
            $orderItem->raw_price_option = $calculatedProduct['raw_price_option'];
            $orderItem->raw_price_count = $calculatedProduct['raw_price_count'];
            $orderItem->raw_price_option_count = $calculatedProduct['raw_price_option_count'];
            $orderItem->amount = $calculatedProduct['amount'];
            $orderItem->percent = $calculatedProduct['percent'];
            $orderItem->off_price = $calculatedProduct['off_price'];
            $orderItem->off_price_option = $calculatedProduct['off_price_option'];
            $orderItem->new_price = $calculatedProduct['new_price'];
            $orderItem->new_price_option = $calculatedProduct['new_price_option'];
            $orderItem->final_raw_price = $calculatedProduct['final_raw_price'];
            $orderItem->final_price = $calculatedProduct['final_price'];
            $orderItem->has_option = $calculatedProduct['has_option'];

            $orderItem->save();
        }

        $orderWithItems = $order->toArray();
        $orderWithItems['order_items'] = $calculatedProductPrice;
        return response()->json($orderWithItems, 201);
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
        return response()->json($order->load('orderItems'));
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
        return response()->json($order->load('orderItems'));
    }



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
        $order->orderItems()->delete();
        $order->delete();
        return response()->json([
            'message' => 'سفارش با موفقیت حذف شد',
        ]);
    }

    public function restore()
    {

    }
}
