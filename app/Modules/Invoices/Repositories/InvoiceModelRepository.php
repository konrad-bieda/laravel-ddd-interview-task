<?php

namespace App\Modules\Invoices\Repositories;

use App\Domain\Invoice\Builders\InvoiceBuilder;
use App\Domain\Invoice\Entities\InvoiceEntity;
use App\Domain\Invoice\Entities\InvoiceProductLineEntity;
use App\Domain\Invoice\Models\Invoice;
use App\Domain\Shared\Entities\CompanyEntity;
use App\Domain\Shared\Entities\ProductEntity;
use App\Domain\Shared\Enums\StatusEnum;
use App\Domain\Shared\ValueObjects\Price;
use App\Infrastructure\Repositories\ModelRepositoryInterface;
use App\Modules\Approval\Infrastructure\Repositories\ApprovalRepositoryInterface;

class InvoiceModelRepository implements ModelRepositoryInterface, InvoiceRepositoryInterface, ApprovalRepositoryInterface
{
    public function create(InvoiceEntity $invoice): void
    {
        $this->query()->create([
            'number' => $invoice->getNumber(),
            'date' => $invoice->getDate(),
            'due_date' => $invoice->getDueDate(),
            'company_id' => $invoice->getCompany()?->getId(),
            'status' => $invoice->getStatus(),
        ]);
    }

    public function approve(string $id): void
    {
        $invoice = $this->query()->findOrFail($id);

        $invoice->status = StatusEnum::APPROVED;
        $invoice->save();
    }

    public function reject(string $id): void
    {
        $invoice = $this->query()->findOrFail($id);

        $invoice->status = StatusEnum::REJECTED;
        $invoice->save();
    }

    public function findById(string $uuid): ?InvoiceEntity
    {
        $invoice = $this->query()->find($uuid);

        if (!$invoice) {
            return null;
        }

        $company = new CompanyEntity(
            name: $invoice->company->name,
            streetAddress: $invoice->company->street,
            city: $invoice->company->city,
            zipCode: $invoice->company->zip,
            phone: $invoice->company->phone,
            id: $invoice->company->id,
            createdAt: $invoice->company->created_at,
            updatedAt: $invoice->company->updated_at,
        );

        $invoiceEntity = new InvoiceEntity(
            number: $invoice->number,
            date: $invoice->date,
            dueDate: $invoice->due_date,
            status: $invoice->status,
            id: $invoice->id,
            createdAt: $invoice->created_at,
            updatedAt: $invoice->updated_at,
            company: $company,
            billedCompany: $company,
        );

        $products = collect();
        foreach ($invoice->productLines as $productLine) {
            if (!$productLine->product) {
                continue;
            }

            $product = new ProductEntity(
                name: $productLine->product->name,
                price: new Price($productLine->product->price, $productLine->product->currency),
                id: $productLine->product->id,
                createdAt: $productLine->product->created_at,
                updatedAt: $productLine->product->updated_at,
            );

            $productLine = new InvoiceProductLineEntity(
                product: $product,
                invoice: $invoiceEntity,
                quantity: $productLine->quantity,
                id: $productLine->id,
                createdAt: $productLine->created_at,
                updatedAt: $productLine->updated_at
            );

            $products->add($productLine);
        }

        $invoiceEntity->setProducts($products);

        return $invoiceEntity;
    }

    public function query(): InvoiceBuilder
    {
        return Invoice::query();
    }
}
