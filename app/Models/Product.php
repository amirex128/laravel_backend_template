<?php

namespace App\Models;

use Database\Factories\ProductFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $total_sales
 * @property int $quantity
 * @property int $price
 * @property int $active
 * @property string $started_at
 * @property string $ended_at
 * @property string $block_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static ProductFactory factory(...$parameters)
 * @method static Builder|Product newModelQuery()
 * @method static Builder|Product newQuery()
 * @method static Builder|Product query()
 * @method static Builder|Product whereActive($value)
 * @method static Builder|Product whereBlockStatus($value)
 * @method static Builder|Product whereCreatedAt($value)
 * @method static Builder|Product whereDescription($value)
 * @method static Builder|Product whereEndedAt($value)
 * @method static Builder|Product whereId($value)
 * @method static Builder|Product whereName($value)
 * @method static Builder|Product wherePrice($value)
 * @method static Builder|Product whereQuantity($value)
 * @method static Builder|Product whereStartedAt($value)
 * @method static Builder|Product whereTotalSales($value)
 * @method static Builder|Product whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $user_id
 * @property int $shop_id
 * @property-read Collection|Category[] $categories
 * @property-read int|null $categories_count
 * @property-read Collection|Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read Collection|Discount[] $discounts
 * @property-read int|null $discounts_count
 * @property-read Collection|Gallery[] $galleries
 * @property-read int|null $galleries_count
 * @property-read Collection|Option[] $options
 * @property-read int|null $options_count
 * @property-read Shop|null $shop
 * @property-read User|null $user
 * @method static Builder|Product whereShopId($value)
 * @method static Builder|Product whereUserId($value)
 * @property Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|Product onlyTrashed()
 * @method static Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Product withoutTrashed()
 */
class Product extends BaseModel
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

    public function comments()
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }

    public function galleries()
    {
        return $this->belongsToMany(Gallery::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class,'discount_product');
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
