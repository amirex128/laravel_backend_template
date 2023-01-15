<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Discount
 *
 * @property int $id
 * @property string $code
 * @property string $started_at
 * @property string $ended_at
 * @property int $count
 * @property int $value
 * @property int $percent
 * @property int $status
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\DiscountFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount wherePercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereValue($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Shop[] $shops
 * @property-read int|null $shops_count
 */
class Discount extends BaseModel
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'discount_product');
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class,'shop_product');
    }
}
