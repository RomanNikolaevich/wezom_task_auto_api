<?php

namespace App\Exceptions;

use Exception;

class ApiResponseException extends Exception
{

    public function __construct(protected string $errorMessage, protected int $statusCode)
    {
        parent::__construct($errorMessage, $statusCode);
    }

    public function getErrorMessage():string
    {
        return $this->errorMessage;
    }
    public function getStatusCode():int
    {
        return $this->statusCode;
    }

}
