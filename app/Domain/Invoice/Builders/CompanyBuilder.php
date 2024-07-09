<?php

namespace App\Domain\Invoice\Builders;

use App\Domain\Invoice\Models\Company;
use App\Infrastructure\Builders\Traits\HasTimestampsColumns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * @method $this whereId(string $value)
 * @method $this whereName(string $value)
 * @method $this whereStreet(string $value)
 * @method $this whereCity(string $value)
 * @method $this whereZip(string $value)
 * @method $this wherePhone(string $value)
 * @method $this whereEmail(string $value)
 *
 * @method Company|EloquentCollection|array|$this|null find($id, $columns = ['*'])
 * @method Company|EloquentCollection|array|$this|null findOrFail($id, $columns = ['*'])
 * @method Company|object|$this|null first($columns = ['*'])
 * @method Company|$this create(array $attributes = [])
 */
class CompanyBuilder extends Builder
{
    use HasTimestampsColumns;
}
