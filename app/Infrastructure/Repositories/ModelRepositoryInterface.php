<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface ModelRepositoryInterface
{
    public function query(): Builder;
}
