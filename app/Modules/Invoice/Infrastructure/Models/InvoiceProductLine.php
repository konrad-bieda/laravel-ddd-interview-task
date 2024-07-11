<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Models;

use App\Modules\Invoice\Infrastructure\Builders\InvoiceProductLineBuilder;
use App\Modules\Invoice\Infrastructure\Database\Factories\InvoiceProductLineFactory;
use App\Modules\Invoice\Infrastructure\Models\Traits\HasTimestampsColumns;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $id
 * @property string $invoice_id
 * @property string $product_id
 * @property int $quantity
 *
 * @property-read Product $product
 * @property-read Invoice $invoice
 *
 * @method static InvoiceProductLineBuilder query()
 * @method static InvoiceProductLineFactory factory(...$parameters)
 */
class InvoiceProductLine extends Model
{
    use HasTimestampsColumns;
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
    ];

    public function newEloquentBuilder($query): InvoiceProductLineBuilder
    {
        return new InvoiceProductLineBuilder($query);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    protected static function newFactory(): InvoiceProductLineFactory
    {
        return InvoiceProductLineFactory::new();
    }
}
