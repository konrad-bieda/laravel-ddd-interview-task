<?php

namespace App\Modules\Invoices\Repositories;

use App\Domain\Invoice\Entities\InvoiceEntity;

interface InvoiceRepositoryInterface
{
    public function create(InvoiceEntity $invoice): void;

    public function findById(string $uuid): ?InvoiceEntity;
}
