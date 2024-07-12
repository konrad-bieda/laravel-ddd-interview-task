<?php

namespace Tests\Unit\Modules\Invoice\Application\Mappers;

use App\Domain\Invoice\Entities\InvoiceProductLineEntity;
use App\Domain\Invoice\Entities\ProductEntity;
use App\Domain\Shared\Enums\CurrencyEnum;
use App\Modules\Invoice\Application\Mappers\InvoiceProductLineEntityMapper;
use App\Modules\Invoice\Infrastructure\Models\InvoiceProductLine;
use App\Modules\Invoice\Infrastructure\Models\Product;
use Mockery\MockInterface;
use Tests\TestCase;

class InvoiceProductLineEntityMapperTest extends TestCase
{
    public function testMapShouldReturnMappedEntity(): void
    {
        /** @var Product $product */
        $product = $this->partialMock(Product::class, function (MockInterface $mock): void {
            $attributes = [
                'id' => $this->faker->uuid(),
                'name' => $this->faker->name(),
                'price' => $this->faker->randomNumber(3),
                'currency' => CurrencyEnum::USD,
                'created_at' => now(),
                'updated_at' => now()->addWeek(),
            ];

            foreach ($attributes as $attribute => $value) {
                $mock->shouldReceive('getAttribute')
                    ->with($attribute)
                    ->andReturn($value);
            }
        });

        /** @var InvoiceProductLine $invoiceProductLine */
        $invoiceProductLine = $this->partialMock(InvoiceProductLine::class, function (MockInterface $mock) use ($product): void {
            $attributes = [
                'product' => $product,
                'quantity' => $this->faker->randomDigitNotZero(),
                'created_at' => now(),
                'updated_at' => now()->addWeek(),
            ];

            foreach ($attributes as $attribute => $value) {
                $mock->shouldReceive('getAttribute')
                    ->with($attribute)
                    ->andReturn($value);
            }
        });

        $invoiceProductLineEntity = InvoiceProductLineEntityMapper::map($invoiceProductLine);

        $this->assertInstanceOf(InvoiceProductLineEntity::class, $invoiceProductLineEntity);
        $this->assertSame($invoiceProductLine->id, $invoiceProductLineEntity->getId());
        $this->assertSame($invoiceProductLine->quantity, $invoiceProductLineEntity->getQuantity());
        $this->assertSame($invoiceProductLine->created_at, $invoiceProductLineEntity->getCreatedAt());
        $this->assertSame($invoiceProductLine->updated_at, $invoiceProductLineEntity->getUpdatedAt());

        $this->assertInstanceOf(ProductEntity::class, $invoiceProductLineEntity->getProduct());
        $this->assertSame($product->id, $invoiceProductLineEntity->getProduct()->getId());
        $this->assertSame($product->name, $invoiceProductLineEntity->getProduct()->getName());
        $this->assertSame($product->price, $invoiceProductLineEntity->getProduct()->getPrice()->getPrice());
        $this->assertSame($product->currency, $invoiceProductLineEntity->getProduct()->getPrice()->getCurrency());
        $this->assertSame($product->created_at, $invoiceProductLineEntity->getProduct()->getCreatedAt());
        $this->assertSame($product->updated_at, $invoiceProductLineEntity->getProduct()->getUpdatedAt());
    }
}
