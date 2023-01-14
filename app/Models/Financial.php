<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Financial
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\FinancialFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Financial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Financial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Financial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Financial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Financial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Financial whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Financial extends BaseModel
{
    use HasFactory;
}
