<?php

namespace App\Domain\Invoice\Models;

use App\Domain\Invoice\Builders\InvoiceBuilder;
use App\Domain\Shared\Enums\StatusEnum;
use App\Domain\Shared\Models\Company;
use App\Domain\Shared\Models\Traits\HasTimestampsColumns;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property int $number
 * @property Carbon $date
 * @property Carbon $due_date
 * @property string $company_id
 * @property StatusEnum $status
 *
 * @property-read Company $company
 * @property-read Collection<InvoiceProductLine> $productLines
 *
 * @method static InvoiceBuilder query()
 * @method static InvoiceFactory factory(...$parameters)
 */
class Invoice extends Model
{
    use HasTimestampsColumns, HasUuids, HasFactory;

    protected $fillable = [
        'number',
        'date',
        'due_date',
        'company_id',
        'status',
    ];

    protected $casts = [
        'date' => 'datetime',
        'due_date' => 'datetime',
        'status' => StatusEnum::class,
    ];

    public function newEloquentBuilder($query): InvoiceBuilder
    {
        return new InvoiceBuilder($query);
    }

    protected static function newFactory(): InvoiceFactory
    {
        return InvoiceFactory::new();
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function productLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }
}
