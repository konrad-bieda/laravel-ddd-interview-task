<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Database\Factories;

use App\Modules\Invoice\Infrastructure\Models\Invoice;
use App\Modules\Invoice\Infrastructure\Models\InvoiceProductLine;
use App\Modules\Invoice\Infrastructure\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
* @extends Factory<InvoiceProductLine>
 *
 * @method InvoiceProductLine create($attributes = [], ?Model $parent = null)
 */
class InvoiceProductLineFactory extends Factory
{
    protected $model = InvoiceProductLine::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'product_id' => Product::factory(),
            'quantity' => $this->faker->randomDigitNotZero(),
        ];
    }
}
