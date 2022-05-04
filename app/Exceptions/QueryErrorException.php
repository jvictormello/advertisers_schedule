<?php

namespace App\Exceptions;

class QueryErrorException extends \Exception
{
    public function __construct(\Throwable $previous) {
        parent::__construct('Query execution error', 500, $previous);
    }
}