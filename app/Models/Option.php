<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Option
 *
 * @property int $id
 * @property string $name
 * @property int $price
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\OptionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Option newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Option query()
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $product_id
 * @property-read \App\Models\Product|null $products
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereProductId($value)
 * @property int $user_id
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Option whereUserId($value)
 */
class Option extends BaseModel
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
