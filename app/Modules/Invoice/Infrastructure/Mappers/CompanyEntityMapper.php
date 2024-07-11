<?php

namespace App\Modules\Invoice\Infrastructure\Mappers;

use App\Domain\Invoice\Entities\CompanyEntity;
use App\Modules\Invoice\Infrastructure\Models\Company;

class CompanyEntityMapper
{
    public static function map(Company $company): CompanyEntity
    {
        return new CompanyEntity(
            name: $company->name,
            streetAddress: $company->street,
            city: $company->city,
            zipCode: $company->zip,
            phone: $company->phone,
            id: $company->id,
            createdAt: $company->created_at,
            updatedAt: $company->updated_at,
        );
    }
}
