<?php

namespace App\Modules\Approval\Api\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Infrastructure\Repositories\ApprovalRepositoryInterface;

readonly class ApproveEntity
{
    public function __construct(private ApprovalRepositoryInterface $repository)
    {
    }

    public function handle(EntityApproved $event): void
    {
        $this->repository->approve($event->approvalDto->id);
    }
}
