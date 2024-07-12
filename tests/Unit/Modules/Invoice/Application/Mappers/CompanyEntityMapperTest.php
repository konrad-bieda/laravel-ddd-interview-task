<?php

namespace Tests\Unit\Modules\Invoice\Application\Mappers;

use App\Domain\Invoice\Entities\CompanyEntity;
use App\Modules\Invoice\Application\Mappers\CompanyEntityMapper;
use App\Modules\Invoice\Infrastructure\Models\Company;
use Mockery\MockInterface;
use Tests\TestCase;

class CompanyEntityMapperTest extends TestCase
{
    public function testMapShouldReturnMappedEntity(): void
    {
        /** @var Company $object */
        $object = $this->partialMock(Company::class, function (MockInterface $mock): void {
            $attributes = [
                'id' => $this->faker->uuid(),
                'name' => $this->faker->name(),
                'street' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'zip' => $this->faker->postcode(),
                'phone' => $this->faker->phoneNumber(),
                'email' => $this->faker->safeEmail(),
                'created_at' => now(),
                'updated_at' => now()->addWeek(),
            ];

            foreach ($attributes as $attribute => $value) {
                $mock->shouldReceive('getAttribute')
                    ->with($attribute)
                    ->andReturn($value);
            }
        });

        $objectEntity = CompanyEntityMapper::map($object);

        $this->assertInstanceOf(CompanyEntity::class, $objectEntity);
        $this->assertSame($object->id, $objectEntity->getId());
        $this->assertSame($object->name, $objectEntity->getName());
        $this->assertSame($object->street, $objectEntity->getStreetAddress());
        $this->assertSame($object->city, $objectEntity->getCity());
        $this->assertSame($object->zip, $objectEntity->getZipCode());
        $this->assertSame($object->phone, $objectEntity->getPhone());
        $this->assertSame($object->email, $objectEntity->getEmailAddress());
        $this->assertSame($object->created_at, $objectEntity->getCreatedAt());
        $this->assertSame($object->updated_at, $objectEntity->getUpdatedAt());
    }
}
