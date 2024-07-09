<?php

declare(strict_types=1);

namespace App\Modules\Invoices\Infrastructure\Providers;

use App\Modules\Approval\Infrastructure\Repositories\ApprovalRepositoryInterface;
use App\Modules\Invoices\Repositories\InvoiceModelRepository;
use App\Modules\Invoices\Repositories\InvoiceRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->scoped(InvoiceRepositoryInterface::class, InvoiceModelRepository::class);
        $this->app->scoped(ApprovalRepositoryInterface::class, InvoiceModelRepository::class);
    }
}
