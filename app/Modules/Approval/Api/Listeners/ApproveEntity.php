<?php

namespace App\Modules\Approval\Api\Listeners;

use App\Modules\Approval\Api\Events\EntityApproved;
use App\Modules\Approval\Infrastructure\Factories\ApprovalRepositoryFactory;

readonly class ApproveEntity
{
    public function handle(EntityApproved $event): void
    {
        ApprovalRepositoryFactory::getRepository($event->approvalDto->entity)->approve($event->approvalDto->id);
    }
}
