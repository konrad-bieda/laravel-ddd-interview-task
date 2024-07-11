<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Mappers;

use App\Domain\Invoice\Entities\InvoiceProductLineEntity;
use App\Modules\Invoice\Infrastructure\Models\InvoiceProductLine;

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
