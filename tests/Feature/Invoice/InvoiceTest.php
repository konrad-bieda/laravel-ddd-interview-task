<?php

namespace Tests\Feature\Invoice;

use App\Domain\Invoice\Models\Invoice;
use App\Domain\Invoice\Models\InvoiceProductLine;
use App\Domain\Shared\Enums\StatusEnum;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    public function testShowWithInvalidIdShouldFail(): void
    {
        $this
            ->get(route('invoice.show', [
                'id' => $this->getInvalidInvoiceId(),
            ]))
            ->assertNotFound();
    }

    public function testShowShouldSucceed(): void
    {
        $data = $this
            ->get(route('invoice.show', [
                'id' => $this->getRandomInvoiceId(),
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'number',
                'date',
                'dueDate',
                'status',
                'createdAt',
                'updatedAt',
                'company',
                'company',
                'billedCompany',
                'products',
                'totalPrice',
            ])->collect();

        $this->assertEmpty($data->get('products'));

        $data = $this
            ->get(route('invoice.show', [
                'id' => $this->getNewInvoiceWithProducts(),
            ]))
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'number',
                'date',
                'dueDate',
                'status',
                'createdAt',
                'updatedAt',
                'company',
                'company',
                'billedCompany',
                'products',
                'totalPrice',
            ])->collect();

        $this->assertNotEmpty($data->get('products'));
    }

    public function testApproveWithInvalidIdShouldFail(): void
    {
        $this
            ->get(route('invoice.approve', [
                'id' => $this->getInvalidInvoiceId(),
            ]))
            ->assertNotFound();
    }

    public function testApproveWithInvalidStatusShouldFail(): void
    {
        $invoice = $this->getNewInvoice([
            'status' => $this->faker()->randomElement([StatusEnum::APPROVED, StatusEnum::REJECTED]),
        ]);

        $this
            ->get(route('invoice.approve', [
                'id' => $invoice->id,
            ]))
            ->assertUnprocessable()
            ->assertJsonFragment([
                'Approval status is already assigned.'
            ])
        ;
    }

    public function testApproveShouldSucceed(): void
    {
        $invoice = $this->getNewInvoice([
            'status' => StatusEnum::DRAFT
        ]);

        $this
            ->get(route('invoice.approve', [
                'id' => $invoice->id,
            ]))
            ->assertOk();

        $invoice->refresh();
        $this->assertSame($invoice->status, StatusEnum::APPROVED);
    }

    public function testRejectWithInvalidIdShouldFail(): void
    {
        $this
            ->get(route('invoice.reject', [
                'id' => $this->getInvalidInvoiceId(),
            ]))
            ->assertNotFound();
    }

    public function testRejectWithInvalidStatusShouldFail(): void
    {
        $invoice = $this->getNewInvoice([
            'status' => $this->faker()->randomElement([StatusEnum::APPROVED, StatusEnum::REJECTED]),
        ]);

        $this
            ->get(route('invoice.reject', [
                'id' => $invoice->id,
            ]))
            ->assertUnprocessable()
            ->assertJsonFragment([
                'Approval status is already assigned.'
            ])
        ;
    }

    public function testRejectShouldSucceed(): void
    {
        $invoice = $this->getNewInvoice([
            'status' => StatusEnum::DRAFT
        ]);

        $this
            ->get(route('invoice.reject', [
                'id' => $invoice->id,
            ]))
            ->assertOk();

        $invoice->refresh();
        $this->assertSame($invoice->status, StatusEnum::REJECTED);
    }

    private function getNewInvoice(array $data = []): Invoice
    {
        return Invoice::factory()->create($data);
    }

    private function getNewInvoiceWithProducts(array $data = []): Invoice
    {
        $invoice = Invoice::factory()->create($data);

        for ($i = 1; $i <= $this->faker()->numberBetween(2, 10); $i++) {
            InvoiceProductLine::factory()->create([
                'invoice_id' => $invoice->id,
            ]);
        }

        return $invoice;
    }

    private function getRandomInvoiceId(): string
    {
        $invoice = Invoice::factory()->create();

        if (!$invoice) {
            return $this->getNewInvoice()->id;
        }

        return$invoice->id;
    }

    private function getInvalidInvoiceId(): ?string
    {
        return '00000000-0000-0000-0000-000000000000';
    }
}
