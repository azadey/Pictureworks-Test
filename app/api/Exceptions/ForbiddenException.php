<?php

namespace Api\Exceptions;

class ForbiddenException extends ClientException
{
    protected $httpCode = 403;

    /**
     * ForbiddenException constructor.
     *
     * @param null $message
     * @param null $debug
     */
    public function __construct($message = null, $debug = null)
    {
        parent::__construct($message, $debug, ExceptionCodes::FORBIDDEN);
    }
}
