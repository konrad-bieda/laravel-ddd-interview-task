<?php

namespace App\Domain\Invoice\Entities;

use App\Domain\Invoice\ValueObjects\Price;
use Carbon\Carbon;

class ProductEntity
{
    public function __construct(
        private string           $name,
        private Price            $price,
        private readonly ?string $id = null,
        private ?Carbon          $createdAt = null,
        private ?Carbon          $updatedAt = null
    )
    {
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
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

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'unitPrice' => $this->getPrice()->getPrice(),
            'currency' => $this->getPrice()->getCurrency(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }
}
