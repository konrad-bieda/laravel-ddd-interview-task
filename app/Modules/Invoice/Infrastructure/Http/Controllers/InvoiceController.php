<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Http\Controllers;

use App\Domain\Shared\Enums\StatusEnum;
use App\Infrastructure\Controller;
use App\Infrastructure\Exceptions\NotFound;
use App\Modules\Invoice\Application\Services\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceService $invoiceService)
    {
    }

    public function show(string $id): JsonResponse
    {
        $object = $this->invoiceService->getOne($id);

        if (!$object) {
            return response()->json('Invoice not found', Response::HTTP_NOT_FOUND);
        }

        return response()->json($object->toArray());
    }

    public function approve(string $id): JsonResponse
    {
        try {
            return response()->json($this->invoiceService->changeStatus($id, StatusEnum::APPROVED));
        } catch (NotFound $e) {
            return response()->json($e->getMessage(), $e->getCode());
        } catch (ValidationException $e) {
            return response()->json($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function reject(string $id): JsonResponse
    {
        try {
            return response()->json($this->invoiceService->changeStatus($id, StatusEnum::REJECTED));
        } catch (NotFound $e) {
            return response()->json($e->getMessage(), $e->getCode());
        } catch (ValidationException $e) {
            return response()->json($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
