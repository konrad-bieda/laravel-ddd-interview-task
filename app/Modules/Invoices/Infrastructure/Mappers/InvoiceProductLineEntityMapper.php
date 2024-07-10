<?php

namespace App\Modules\Invoices\Infrastructure\Mappers;

use App\Domain\Invoice\Entities\InvoiceProductLineEntity;
use App\Modules\Invoices\Infrastructure\Models\InvoiceProductLine;

class InvoiceProductLineEntityMapper
{
    public static function map(InvoiceProductLine $invoiceProductLine): InvoiceProductLineEntity
    {
        return new InvoiceProductLineEntity(
            product: ProductEntityMapper::map($invoiceProductLine->product),
            quantity: $invoiceProductLine->quantity,
            id: $invoiceProductLine->id,
            createdAt: $invoiceProductLine->created_at,
            updatedAt: $invoiceProductLine->updated_at
        );
    }
}
