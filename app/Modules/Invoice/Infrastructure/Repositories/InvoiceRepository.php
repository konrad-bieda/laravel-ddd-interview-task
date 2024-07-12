<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Repositories;

use App\Domain\Invoice\Entities\InvoiceEntity;
use App\Domain\Shared\Enums\StatusEnum;
use App\Infrastructure\Repositories\ModelRepository;
use App\Modules\Approval\Infrastructure\Repositories\ApprovalRepositoryInterface;
use App\Modules\Invoice\Infrastructure\Builders\InvoiceBuilder;
use App\Modules\Invoice\Infrastructure\Models\Invoice;

class InvoiceRepository extends ModelRepository implements ApprovalRepositoryInterface
{
    public function create(InvoiceEntity $invoice): void
    {
        $this->query()->create([
            'number' => $invoice->getInvoiceNumber(),
            'date' => $invoice->getInvoiceDate(),
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
