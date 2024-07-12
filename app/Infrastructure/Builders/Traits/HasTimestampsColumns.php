<?php

declare(strict_types=1);

namespace App\Infrastructure\Builders\Traits;

use Carbon\Carbon;

/**
 * @method $this whereCreatedAt(Carbon $value)
 * @method $this whereUpdatedAt(Carbon $value)
 */
trait HasTimestampsColumns
{
}
