<?php

namespace App\Domain\Invoice\Entities;

use App\Domain\Shared\Enums\StatusEnum;
use Carbon\Carbon;

class InvoiceEntity
{
    private string $id;
    private string $number;
    private Carbon $date;
    private Carbon $dueDate;
    private string $companyId;
    private StatusEnum $status;
    private Carbon $createdAt;
    private Carbon $updatedAt;

    public function __construct(
        string $number,
        Carbon $date,
        Carbon $dueDate,
        string $companyId,
        StatusEnum $status,
        ?string $id = null,
        ?Carbon $createdAt = null,
        ?Carbon $updatedAt = null
    ) {
        $this->id = $id;
        $this->number = $number;
        $this->date = $date;
        $this->dueDate = $dueDate;
        $this->companyId = $companyId;
        $this->status = $status;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function getDueDate(): Carbon
    {
        return $this->dueDate;
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'number' => $this->getNumber(),
            'date' => $this->getDate(),
            'dueDate' => $this->getDueDate(),
            'companyId' => $this->getCompanyId(),
            'status' => $this->getStatus(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }
}
