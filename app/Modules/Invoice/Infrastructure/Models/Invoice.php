<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Models;

use App\Domain\Shared\Enums\StatusEnum;
use App\Infrastructure\Models\Traits\HasTimestampsColumns;
use App\Modules\Invoice\Infrastructure\Builders\InvoiceBuilder;
use App\Modules\Invoice\Infrastructure\Database\Factories\InvoiceFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string $id
 * @property string $number
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
    use HasTimestampsColumns;
    use HasUuids;
    use HasFactory;

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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function productLines(): HasMany
    {
        return $this->hasMany(InvoiceProductLine::class);
    }

    protected static function newFactory(): InvoiceFactory
    {
        return InvoiceFactory::new();
    }
}
