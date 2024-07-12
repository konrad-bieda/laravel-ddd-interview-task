<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Application\Mappers;

use App\Domain\Invoice\Entities\ProductEntity;
use App\Domain\Shared\ValueObjects\Price;
use App\Modules\Invoice\Infrastructure\Models\Product;

class ProductEntityMapper
{
    public static function map(Product $product): ProductEntity
    {
        return new ProductEntity(
            name: $product->name,
            price: new Price($product->price, $product->currency),
            id: $product->id,
            createdAt: $product->created_at,
            updatedAt: $product->updated_at,
        );
    }
}
