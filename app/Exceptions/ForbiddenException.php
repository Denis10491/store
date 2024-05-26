<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{
    protected $error_code;

    public function __construct()
    {
        parent::__construct('Forbidden,', 403);
        $this->error_code = 403;
    }

    public function getErrorMessage()
    {
        return $this->message;
    }
}
