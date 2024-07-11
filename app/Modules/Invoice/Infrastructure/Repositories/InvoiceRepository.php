<?php

namespace App\Modules\Invoice\Infrastructure\Repositories;

use App\Domain\Invoice\Entities\InvoiceEntity;
use App\Domain\Invoice\Enums\StatusEnum;
use App\Infrastructure\Repositories\ModelRepositoryInterface;
use App\Modules\Approval\Infrastructure\Repositories\ApprovalRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Builders\InvoiceBuilder;
use App\Modules\Invoice\Infrastructure\Models\Invoice;

class InvoiceRepository implements ModelRepositoryInterface, ApprovalRepositoryInterface
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

    public function findById(string $uuid): ?Invoice
    {
        return $this->query()->find($uuid);
    }

    public function query(): InvoiceBuilder
    {
        return Invoice::query();
    }
}
