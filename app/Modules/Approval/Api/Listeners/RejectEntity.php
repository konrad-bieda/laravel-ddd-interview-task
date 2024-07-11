<?php

namespace App\Modules\Approval\Api\Listeners;

use App\Modules\Approval\Api\Events\EntityRejected;
use App\Modules\Approval\Infrastructure\Factories\ApprovalRepositoryFactory;

readonly class RejectEntity
{
    public function handle(EntityRejected $event): void
    {
        ApprovalRepositoryFactory::getRepository($event->approvalDto->entity)->reject($event->approvalDto->id);
    }
}
