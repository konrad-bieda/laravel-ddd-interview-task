<?php

declare(strict_types=1);

namespace App\Domain\Shared\ValueObjects;

use App\Domain\Shared\Enums\CurrencyEnum;

readonly class Price
{
    public function __construct(
        private int $price,
        private CurrencyEnum $currency = CurrencyEnum::USD,
    ) {
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }
}
