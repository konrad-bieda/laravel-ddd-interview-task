<?php

namespace App\Modules\Invoice\Infrastructure\Database\Factories;

use App\Domain\Invoice\Enums\StatusEnum;
use App\Modules\Invoice\Infrastructure\Models\Company;
use App\Modules\Invoice\Infrastructure\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
* @extends Factory<Invoice>
 *
 * @method Invoice create($attributes = [], ?Model $parent = null)
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'number' => $this->faker->uuid(),
            'date' => now(),
            'due_date' => now()->addMonth(),
            'company_id' => Company::factory(),
            'status' => StatusEnum::DRAFT,
        ];
    }
}
