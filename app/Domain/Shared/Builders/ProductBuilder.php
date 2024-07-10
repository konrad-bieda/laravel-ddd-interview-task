<?php

namespace App\Domain\Shared\Builders;

use App\Domain\Shared\Models\Product;
use App\Infrastructure\Builders\Traits\HasTimestampsColumns;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

/**
 * @method $this whereId(string $value)
 * @method $this whereName(string $value)
 * @method $this wherePrice(int $value)
 * @method $this whereCurrency(string $value)
 *
 * @method Product|EloquentCollection|array|$this|null find($id, $columns = ['*'])
 * @method Product|EloquentCollection|array|$this|null findOrFail($id, $columns = ['*'])
 * @method Product|object|$this|null first($columns = ['*'])
 * @method Product|$this create(array $attributes = [])
 */
class ProductBuilder extends Builder
{
    use HasTimestampsColumns;
}
