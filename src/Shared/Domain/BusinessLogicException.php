<?php

namespace App\Shared\Domain;

use RuntimeException;

class BusinessLogicException extends RuntimeException
{
    public function __construct(string $description)
    {
        parent::__construct($description);
    }

}
