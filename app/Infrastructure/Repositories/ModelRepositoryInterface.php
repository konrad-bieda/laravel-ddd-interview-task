<?php

namespace App\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface ModelRepositoryInterface
{
    public function query(): Builder;
}
