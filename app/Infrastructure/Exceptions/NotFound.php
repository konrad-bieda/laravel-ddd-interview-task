<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class NotFound extends Exception
{
    public function __construct(string $message = 'Resource not found', int $code = Response::HTTP_NOT_FOUND)
    {
        parent::__construct($message, $code);
    }
}
