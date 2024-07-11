<?php

namespace Tests\Unit\Modules\Invoice\Application\Mappers;

use App\Domain\Invoice\Entities\ProductEntity;
use App\Modules\Invoice\Application\Mappers\ProductEntityMapper;
use App\Modules\Invoice\Infrastructure\Models\Product;
use Mockery\MockInterface;
use Tests\TestCase;

class ProductEntityMapperTest extends TestCase
{
    public function testMapShouldReturnMappedEntity(): void
    {
        /** @var Product $object */
        $object = $this->partialMock(Product::class, function (MockInterface $mock): void {
            $attributes = [
                'id' => $this->faker->uuid(),
                'name' => $this->faker->name(),
                'price' => $this->faker->randomNumber(3),
                'currency' => $this->faker->currencyCode(),
                'created_at' => now(),
                'updated_at' => now()->addWeek(),
            ];

            foreach ($attributes as $attribute => $value) {
                $mock->shouldReceive('getAttribute')
                    ->with($attribute)
                    ->andReturn($value);
            }
        });

        $objectEntity = ProductEntityMapper::map($object);

        $this->assertInstanceOf(ProductEntity::class, $objectEntity);
        $this->assertSame($object->id, $objectEntity->getId());
        $this->assertSame($object->name, $objectEntity->getName());
        $this->assertSame($object->price, $objectEntity->getPrice()->getPrice());
        $this->assertSame($object->currency, $objectEntity->getPrice()->getCurrency());
        $this->assertSame($object->created_at, $objectEntity->getCreatedAt());
        $this->assertSame($object->updated_at, $objectEntity->getUpdatedAt());
    }
}
