<?php

namespace App\Modules\Invoices\Repositories;

use App\Domain\Invoice\Builders\InvoiceBuilder;
use App\Domain\Invoice\Entities\InvoiceEntity;
use App\Domain\Invoice\Models\Invoice;
use App\Domain\Shared\Enums\StatusEnum;
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
           'company_id' => $invoice->getCompanyId(),
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

        return new InvoiceEntity(
            $invoice->number,
            $invoice->date,
            $invoice->due_date,
            $invoice->company_id,
            $invoice->status,
            $invoice->id,
            $invoice->created_at,
            $invoice->updated_at
        );
    }

    public function query(): InvoiceBuilder
    {
        return Invoice::query();
    }
}
