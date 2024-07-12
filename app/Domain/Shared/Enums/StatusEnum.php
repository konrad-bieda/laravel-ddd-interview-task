<?php

declare(strict_types=1);

namespace App\Domain\Shared\Enums;

enum StatusEnum: string
{
    case DRAFT = 'draft';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
