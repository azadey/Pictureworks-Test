<?php

namespace Api\Exceptions;

use Log;


/**
 * Thrown in case of a server exception. All error cases which should result in a 5XX
 * error code must use this exception class or a sub class
 *
 * @package App\Partners\Exceptions
 */
class ServerException extends BaseException
{
    protected $httpCode = 500;

    /**
     * ServerException constructor.
     *
     * @param array|string $data
     * @param array|string $debug
     * @param string       $type
     */
    public function __construct($data = null, $debug = null, $type = null)
    {
        $type = $type ? : ExceptionCodes::SERVER_ERROR;
        parent::__construct($type, $data, $debug);
    }

    /**
     * Log exception
     *
     * @param string $tag
     */
    public function logException($tag = '')
    {
        Log::error($this->getLogStatement($tag));
    }
}
