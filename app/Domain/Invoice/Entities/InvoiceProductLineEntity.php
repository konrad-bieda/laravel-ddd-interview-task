<?php

namespace App\Domain\Invoice\Entities;

use Carbon\Carbon;

class InvoiceProductLineEntity
{
    public function __construct(
        private InvoiceEntity    $invoice,
        private ProductEntity    $product,
        private int              $quantity,
        private readonly ?string $id = null,
        private ?Carbon          $createdAt = null,
        private ?Carbon          $updatedAt = null,
    )
    {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getInvoice(): InvoiceEntity
    {
        return $this->invoice;
    }

    public function setInvoice(InvoiceEntity $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getProduct(): ProductEntity
    {
        return $this->product;
    }

    public function setProduct(ProductEntity $product): void
    {
        $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
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

    public function getTotal(): int
    {
        return $this->product->getPrice()->getPrice() * $this->quantity;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'invoice' => $this->getInvoice()->toArray(),
            'product' => $this->getProduct()->toArray(),
            'quantity' => $this->getQuantity(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }
}
