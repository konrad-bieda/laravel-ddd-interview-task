<?php

declare(strict_types=1);

namespace App\Modules\Shared\Application\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

readonly class Service
{
    /**
     * @throws ValidationException
     */
    protected function validate(array $fields, array $rules, array $message = [], array $customAttributes = []): void
    {
        foreach ($fields as &$field) {
            if ($field instanceof Collection) {
                $field = $field->toArray();
            }
        }
        unset($field);

        Validator::make($fields, $rules, $message, $customAttributes)->validate();
    }
}
