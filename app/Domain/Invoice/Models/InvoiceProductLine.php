<?php

namespace App\Domain\Invoice\Models;

use App\Domain\Invoice\Builders\InvoiceProductLineBuilder;
use App\Domain\Shared\Models\Product;
use App\Domain\Shared\Models\Traits\HasTimestampsColumns;
use App\Modules\Invoices\Infrastructure\Database\Factories\InvoiceProductLineFactory;
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
    use HasTimestampsColumns, HasUuids, HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'quantity',
    ];

    public function newEloquentBuilder($query): InvoiceProductLineBuilder
    {
        return new InvoiceProductLineBuilder($query);
    }

    protected static function newFactory(): InvoiceProductLineFactory
    {
        return InvoiceProductLineFactory::new();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
