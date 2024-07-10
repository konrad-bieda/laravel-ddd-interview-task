<?php

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Domain\Invoice\Entities\ProductEntity;
use App\Domain\Invoice\ValueObjects\Price;
use App\Modules\Invoices\Infrastructure\Models\Product;

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
