<?php

declare(strict_types=1);

namespace App\Modules\Invoice\Infrastructure\Models;

use App\Modules\Invoice\Infrastructure\Builders\CompanyBuilder;
use App\Modules\Invoice\Infrastructure\Database\Factories\CompanyFactory;
use App\Modules\Invoice\Infrastructure\Models\Traits\HasTimestampsColumns;
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
    use HasTimestampsColumns;
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'city',
        'zip',
        'phone',
        'email',
    ];

    public function newEloquentBuilder($query): CompanyBuilder
    {
        return new CompanyBuilder($query);
    }

    protected static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }
}
