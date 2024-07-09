<?php

namespace App\Modules\Invoices\Application\Services;

use App\Domain\Invoice\Entities\InvoiceEntity;
use App\Domain\Shared\Enums\StatusEnum;
use App\Infrastructure\Exceptions\NotFound;
use App\Modules\Approval\Api\ApprovalFacadeInterface;
use App\Modules\Approval\Api\Dto\ApprovalDto;
use App\Modules\Invoices\Repositories\InvoiceRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

readonly class InvoiceService
{
    public function __construct(
        private InvoiceRepositoryInterface $repository,
        private ApprovalFacadeInterface    $approvalFacade
    )
    {
    }

    public function getOne(string $id): ?InvoiceEntity
    {
        return $this->repository->findById($id);
    }

    /**
     * @throws NotFound|ValidationException
     */
    public function changeStatus(string $id, StatusEnum $status): true
    {
        $invoice = $this->getOne($id);

        if (!$invoice) {
            throw new NotFound('Invoice not found');
        }

        $this->validateChangeStatus($invoice->getStatus()->value);

        $dto = new ApprovalDto(
            Uuid::fromString($id),
            $invoice->getStatus(),
            InvoiceEntity::class
        );

        return match ($status) {
            StatusEnum::APPROVED => $this->approvalFacade->approve($dto),
            StatusEnum::REJECTED => $this->approvalFacade->reject($dto),
            default => throw new InvalidArgumentException('Invalid DTO status.'),
        };
    }

    /**
     * @throws ValidationException
     */
    private function validateChangeStatus(string $status): void
    {
        $this->validate(
            compact('status'),
            [
                'status' => [
                    Rule::in(StatusEnum::DRAFT->value)
                ],
            ],
            [
                'status' => 'Approval status is already assigned.',
            ]
        );
    }

    /**
     * @throws ValidationException
     */
    protected function validate(array $fields, array $rules, array $message = [], array $customAttributes = []): void
    {
        foreach ($fields as &$field) {
            if ($field instanceof Collection) {
                $field = $field->toArray();
            }
        }
        unset($field);

        Validator::make($fields, $rules, $message, $customAttributes)->validate();
    }
}
