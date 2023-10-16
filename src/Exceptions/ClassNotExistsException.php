<?php

namespace H2o\SharedCache\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;
class ClassNotExistsException extends HttpException
{
    public function __construct()
    {
        parent::__construct($this->code, $this->message);
    }

    protected $code = 500;

    protected $message = "Cache Class Not Exist";
}
