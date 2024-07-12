<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Models;

use App\Domain\Shared\Enums\CurrencyEnum;
use App\Infrastructure\Models\Traits\HasTimestampsColumns;
use App\Modules\Invoice\Infrastructure\Builders\ProductBuilder;
use App\Modules\Invoice\Infrastructure\Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @property string $id
* @property string $name
* @property int $price
* @property CurrencyEnum $currency
*
* @method static ProductBuilder query()
* @method static ProductFactory factory(...$parameters)
*/
class Product extends Model
{
    use HasTimestampsColumns;
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'currency',
    ];

    protected $casts = [
      'currency' => CurrencyEnum::class,
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
