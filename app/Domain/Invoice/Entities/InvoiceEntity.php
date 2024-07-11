<?php

declare(strict_types=1);

namespace App\Domain\Invoice\Entities;

use App\Domain\Invoice\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class InvoiceEntity
{
    public function __construct(
        private string $number,
        private Carbon $date,
        private Carbon $dueDate,
        private StatusEnum $status,
        private readonly ?string $id = null,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null,
        private ?CompanyEntity $company = null,
        private ?CompanyEntity $billedCompany = null,
        private ?Collection $products = null
    ) {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function setDate(Carbon $date): void
    {
        $this->date = $date;
    }

    public function getDueDate(): Carbon
    {
        return $this->dueDate;
    }

    public function setDueDate(Carbon $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    public function getStatus(): StatusEnum
    {
        return $this->status;
    }

    public function setStatus(StatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?Carbon $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?Carbon $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getCompany(): ?CompanyEntity
    {
        return $this->company;
    }

    public function setCompany(?CompanyEntity $company): void
    {
        $this->company = $company;
    }

    public function getBilledCompany(): ?CompanyEntity
    {
        return $this->billedCompany;
    }

    public function setBilledCompany(?CompanyEntity $billedCompany): void
    {
        $this->billedCompany = $billedCompany;
    }

    public function getProducts(): ?Collection
    {
        return $this->products;
    }

    public function setProducts(?Collection $products): void
    {
        $this->products = $products;
    }

    public function getTotalPrice(): int
    {
        $total = 0;

        if (!$this->products || $this->products->isEmpty()) {
            return $total;
        }

        /** @var InvoiceProductLineEntity $product */
        foreach ($this->products as $product) {
            $total = bcadd((string) $total, (string) $product->getTotal());
        }

        return (int) $total;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'number' => $this->getNumber(),
            'date' => $this->getDate(),
            'dueDate' => $this->getDueDate(),
            'status' => $this->getStatus(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
            'company' => $this->getCompany()?->toArray(),
            'billedCompany' => $this->getBilledCompany()?->toArray(),
            'products' => $this->getProducts()?->map(function (InvoiceProductLineEntity $item) {
                return [
                    'name' => $item->getProduct()->getName(),
                    'quantity' => $item->getQuantity(),
                    'unitPrice' => $item->getProduct()->getPrice()->getPrice(),
                    'total' => $item->getTotal(),
                ];
            }),
            'totalPrice' => $this->getTotalPrice(),
        ];
    }
}
