<?php

namespace App\Modules\Approval\Infrastructure\Repositories;

interface ApprovalRepositoryInterface
{
    public function approve(string $id): void;

    public function reject(string $id): void;
}
