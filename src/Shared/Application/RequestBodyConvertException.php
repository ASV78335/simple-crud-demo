<?php

namespace App\Shared\Application;

use RuntimeException;

class RequestBodyConvertException extends RuntimeException
{
    public function __construct(\Throwable $previous)
    {
        parent::__construct('Error while unmarshalling request body', 0, $previous);
    }
}
