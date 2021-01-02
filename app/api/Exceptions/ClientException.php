<?php

namespace Api\Exceptions;

use Log;


/**
 * Thrown in case of a client exception. All error cases which result in a 4XX series
 * error code must use this exception or a sub class
 *
 * @package App\Partners\Exceptions
 */
class ClientException extends BaseException
{
    protected $httpCode = 400;

    /**
     * ClientException constructor.
     *
     * @param string|array $data if a string is given this is set as the message
     * @param null         $debug
     * @param null         $type
     */
    public function __construct($data, $debug = null, $type = null)
    {
        $type = $type ? : ExceptionCodes::BAD_REQUEST;

        if (is_string($data)) {
            $message = $data;
            $data    = null;
        } else {
            $message = null;
        }

        parent::__construct($type, $data, $debug);

        if ($message != null) {
            parent::setMessage($message);
        }
    }

    /**
     * Log exception
     *
     * @param string $tag
     */
    public function logException($tag = '')
    {
        Log::notice($this->getLogStatement($tag));
    }
}
