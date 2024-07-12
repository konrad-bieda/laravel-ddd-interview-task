<?php

namespace Tests\Unit\Modules\Invoice\Application\Mappers;

use App\Domain\Invoice\Entities\CompanyEntity;
use App\Domain\Invoice\Entities\InvoiceEntity;
use App\Domain\Invoice\Entities\InvoiceProductLineEntity;
use App\Domain\Shared\Enums\StatusEnum;
use App\Modules\Invoice\Application\Mappers\InvoiceEntityMapper;
use App\Modules\Invoice\Infrastructure\Models\Company;
use App\Modules\Invoice\Infrastructure\Models\Invoice;
use App\Modules\Invoice\Infrastructure\Models\InvoiceProductLine;
use App\Modules\Invoice\Infrastructure\Models\Product;
use Illuminate\Support\Collection;
use Mockery\MockInterface;
use Tests\TestCase;

class InvoiceEntityMapperTest extends TestCase
{
    public function testMapShouldReturnMappedEntity(): void
    {
        /** @var Company $company */
        $company = $this->partialMock(Company::class, function (MockInterface $mock): void {
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

        /** @var Product $product */
        $product = $this->partialMock(Product::class, function (MockInterface $mock): void {
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

        /** @var Invoice $invoice */
        $invoice = $this->partialMock(Invoice::class, function (MockInterface $mock) use ($company, $invoiceProductLine): void {
            $attributes = [
                'id' => $this->faker->uuid(),
                'number' => $this->faker->uuid(),
                'date' => now(),
                'due_date' => now()->addMonth(),
                'status' => $this->faker()->randomElement([StatusEnum::DRAFT, StatusEnum::APPROVED, StatusEnum::APPROVED]),
                'created_at' => now(),
                'updated_at' => now()->addWeek(),
                'productLines' => collect([$invoiceProductLine]),
                'company' => $company,
            ];

            foreach ($attributes as $attribute => $value) {
                $mock->shouldReceive('getAttribute')
                    ->with($attribute)
                    ->andReturn($value);
            }
        });

        $invoiceEntity = InvoiceEntityMapper::map($invoice);

        $this->assertInstanceOf(InvoiceEntity::class, $invoiceEntity);
        $this->assertSame($invoice->id, $invoiceEntity->getId());
        $this->assertSame($invoice->number, $invoiceEntity->getNumber());
        $this->assertSame($invoice->date, $invoiceEntity->getDate());
        $this->assertSame($invoice->due_date, $invoiceEntity->getDueDate());
        $this->assertSame($invoice->status, $invoiceEntity->getStatus());
        $this->assertSame($invoice->created_at, $invoiceEntity->getCreatedAt());
        $this->assertSame($invoice->updated_at, $invoiceEntity->getUpdatedAt());
        $invoiceTotalPrice = (int) bcmul($product->price, $invoiceProductLine->quantity);
        $this->assertSame($invoiceTotalPrice, $invoiceEntity->getTotalPrice());

        $this->assertInstanceOf(CompanyEntity::class, $invoiceEntity->getCompany());
        $this->assertSame($company->id, $invoiceEntity->getCompany()->getId());
        $this->assertSame($company->name, $invoiceEntity->getCompany()->getName());
        $this->assertSame($company->street, $invoiceEntity->getCompany()->getStreetAddress());
        $this->assertSame($company->city, $invoiceEntity->getCompany()->getCity());
        $this->assertSame($company->zip, $invoiceEntity->getCompany()->getZipCode());
        $this->assertSame($company->phone, $invoiceEntity->getCompany()->getPhone());
        $this->assertSame($company->email, $invoiceEntity->getCompany()->getEmailAddress());
        $this->assertSame($company->created_at, $invoiceEntity->getCompany()->getCreatedAt());
        $this->assertSame($company->updated_at, $invoiceEntity->getCompany()->getUpdatedAt());

        $this->assertInstanceOf(CompanyEntity::class, $invoiceEntity->getBilledCompany());
        $this->assertSame($company->id, $invoiceEntity->getBilledCompany()->getId());
        $this->assertSame($company->name, $invoiceEntity->getBilledCompany()->getName());
        $this->assertSame($company->street, $invoiceEntity->getBilledCompany()->getStreetAddress());
        $this->assertSame($company->city, $invoiceEntity->getBilledCompany()->getCity());
        $this->assertSame($company->zip, $invoiceEntity->getBilledCompany()->getZipCode());
        $this->assertSame($company->phone, $invoiceEntity->getBilledCompany()->getPhone());
        $this->assertSame($company->email, $invoiceEntity->getBilledCompany()->getEmailAddress());
        $this->assertSame($company->created_at, $invoiceEntity->getBilledCompany()->getCreatedAt());
        $this->assertSame($company->updated_at, $invoiceEntity->getBilledCompany()->getUpdatedAt());

        $this->assertInstanceOf(Collection::class, $invoiceEntity->getProducts());
        $this->assertCount($invoice->productLines->count(), $invoiceEntity->getProducts());

        /** @var InvoiceProductLineEntity $invoiceProductLineEntity */
        $invoiceProductLineEntity = $invoiceEntity->getProducts()->first();
        $this->assertInstanceOf(InvoiceProductLineEntity::class, $invoiceProductLineEntity);
        $this->assertSame($invoiceProductLine->id, $invoiceProductLineEntity->getId());
        $this->assertSame($invoiceProductLine->quantity, $invoiceProductLineEntity->getQuantity());
        $this->assertSame($invoiceProductLine->created_at, $invoiceProductLineEntity->getCreatedAt());
        $this->assertSame($invoiceProductLine->updated_at, $invoiceProductLineEntity->getUpdatedAt());
        $this->assertSame($product->id, $invoiceProductLineEntity->getProduct()->getId());
        $this->assertSame($product->name, $invoiceProductLineEntity->getProduct()->getName());
        $this->assertSame($product->price, $invoiceProductLineEntity->getProduct()->getPrice()->getPrice());
        $this->assertSame($product->currency, $invoiceProductLineEntity->getProduct()->getPrice()->getCurrency());
        $this->assertSame($product->created_at, $invoiceProductLineEntity->getProduct()->getCreatedAt());
        $this->assertSame($product->updated_at, $invoiceProductLineEntity->getProduct()->getUpdatedAt());

        $invoiceProductLineTotalPrice = (int) bcmul($product->price, $invoiceProductLine->quantity);
        $this->assertSame($invoiceProductLineTotalPrice, $invoiceProductLineEntity->getTotal());
    }
}
