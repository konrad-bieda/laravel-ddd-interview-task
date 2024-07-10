<?php

namespace App\Domain\Invoice\Builders;

use App\Domain\Invoice\Models\InvoiceProductLine;
use App\Infrastructure\Builders\Traits\HasTimestampsColumns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * @method $this whereId(string $value)
 * @method $this whereProductId(string $value)
 * @method $this whereInvoiceId(string $value)
 * @method $this whereQuantity(int $value)
 *
 * @method InvoiceProductLine|EloquentCollection|array|$this|null find($id, $columns = ['*'])
 * @method InvoiceProductLine|EloquentCollection|array|$this|null findOrFail($id, $columns = ['*'])
 * @method InvoiceProductLine|object|$this|null first($columns = ['*'])
 * @method InvoiceProductLine|$this create(array $attributes = [])
 */
class InvoiceProductLineBuilder extends Builder
{
    use HasTimestampsColumns;
}
