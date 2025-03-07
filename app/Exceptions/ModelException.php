<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ModelException extends HttpException
{
    public function __construct(
        public $message,
    ) {
        parent::__construct(422, $this->message);
    }
}
