<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Models\Traits;

use Carbon\Carbon;

/**
 * Trait HasTimestampsColumns handles adding properties for create and update at columns to model.
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
trait HasTimestampsColumns
{
}
