<?php

namespace Api\Exceptions;

class InvariantViolationException extends ServerException
{
    public function __construct($message, $debug = null)
    {
        parent::__construct($message, $debug, ExceptionCodes::INVARIANT_VIOLATION);
    }
}
