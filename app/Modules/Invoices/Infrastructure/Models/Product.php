<?php

namespace App\Modules\Invoices\Infrastructure\Models;

use App\Modules\Invoices\Infrastructure\Builders\ProductBuilder;
use App\Modules\Invoices\Infrastructure\Models\Traits\HasTimestampsColumns;
use App\Modules\Shared\Infrastructure\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @property string $id
* @property string $name
* @property int $price
* @property string $currency
*
* @method static ProductBuilder query()
* @method static ProductFactory factory(...$parameters)
*/
class Product extends Model
{
    use HasTimestampsColumns, HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'price',
        'currency',
    ];

    public function newEloquentBuilder($query): ProductBuilder
    {
        return new ProductBuilder($query);
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }
}
