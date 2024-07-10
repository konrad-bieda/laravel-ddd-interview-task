<?php

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Domain\Invoice\Entities\InvoiceEntity;
use App\Modules\Invoices\Infrastructure\Models\Invoice;

class InvoiceEntityMapper
{
    public static function map(Invoice $invoice): InvoiceEntity
    {
        $products = collect();
        foreach ($invoice->productLines as $productLine) {
            if (!$productLine->product) {
                continue;
            }

            $productLine = InvoiceProductLineEntityMapper::map($productLine);
            $products->add($productLine);
        }

        return new InvoiceEntity(
            number: $invoice->number,
            date: $invoice->date,
            dueDate: $invoice->due_date,
            status: $invoice->status,
            id: $invoice->id,
            createdAt: $invoice->created_at,
            updatedAt: $invoice->updated_at,
            company: CompanyEntityMapper::map($invoice->company),
            billedCompany: CompanyEntityMapper::map($invoice->company), // TODO should be another DB column for that?
            products: $products
        );
    }
}
