<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $ip
 * @property int $total_product_price
 * @property int $total_discount_price
 * @property int $total_tax_price
 * @property int $total_product_discount_price
 * @property int $total_final_price
 * @property int $send_price
 * @property string $status
 * @property string $description
 * @property string $package_size
 * @property string $tracking_code
 * @property string $courier
 * @property string $last_update_status_at
 * @property int $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\OrderFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCourier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereLastUpdateStatusAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePackageSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSendPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalFinalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalProductDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalTaxPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTrackingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereWeight($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property int $shop_id
 * @property int $customer_id
 * @property int $discount_id
 * @property int $address_id
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\Discount|null $discount
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OrderItem[] $orderItems
 * @property-read int|null $order_items_count
 * @property-read \App\Models\Shop|null $shop
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 */
class Order extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
