<?php

namespace App\Modules\Invoices\Infrastructure\Builders;

use App\Domain\Invoice\Enums\StatusEnum;
use App\Infrastructure\Builders\Traits\HasTimestampsColumns;
use App\Modules\Invoices\Infrastructure\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * @method $this whereId(string $value)
 * @method $this whereDate(Carbon $value)
 * @method $this whereDueDate(Carbon $value)
 * @method $this whereCompanyId(string $value)
 * @method $this whereStatus(StatusEnum $value)
 *
 * @method Invoice|EloquentCollection|array|$this|null find($id, $columns = ['*'])
 * @method Invoice|EloquentCollection|array|$this|null findOrFail($id, $columns = ['*'])
 * @method Invoice|object|$this|null first($columns = ['*'])
 * @method Invoice|$this create(array $attributes = [])
 */
class InvoiceBuilder extends Builder
{
    use HasTimestampsColumns;
}
