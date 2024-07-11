<?php

declare(strict_types=1);

namespace App\Modules\Approval\Infrastructure\Repositories;

interface ApprovalRepositoryInterface
{
    public function approve(string $id): void;

    public function reject(string $id): void;
}
