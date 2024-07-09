<?php

namespace App\Modules\Approval\Api\Listeners;

use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Approval\Infrastructure\Repositories\ApprovalRepositoryInterface;

readonly class RejectEntity
{
    public function __construct(private ApprovalRepositoryInterface $repository)
    {
    }

    public function handle(EntityRejected $event): void
    {
        $this->repository->reject($event->approvalDto->id);
    }
}
