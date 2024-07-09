<?php

namespace App\Domain\Invoice\Models;

use App\Domain\Invoice\Builders\CompanyBuilder;
use App\Domain\Invoice\Builders\InvoiceBuilder;
use App\Domain\Shared\Models\Traits\HasTimestampsColumns;
use App\Modules\Invoices\Infrastructure\Database\Factories\CompanyFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @property string $id
* @property string $name
* @property string $street
* @property string $city
* @property string $zip
* @property string $phone
* @property string $email
*
* @method static CompanyBuilder query()
* @method static CompanyFactory factory(...$parameters)
*/
class Company extends Model
{
    use HasTimestampsColumns, HasUuids, HasFactory;

    protected $fillable = [
        'name',
        'street',
        'city',
        'zip',
        'phone',
        'email',
    ];

    public function newEloquentBuilder($query): InvoiceBuilder
    {
        return new InvoiceBuilder($query);
    }

    protected static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }
}
