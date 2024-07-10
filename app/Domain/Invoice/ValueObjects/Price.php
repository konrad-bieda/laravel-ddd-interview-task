<?php

namespace App\Domain\Invoice\ValueObjects;

readonly class Price
{
    public function __construct(
        private int    $price,
        private string $currency,
    )
    {
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
