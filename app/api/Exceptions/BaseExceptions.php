<?php

namespace Api\Exceptions;

use Api\Core\Helpers\AppHelpers;
use Log;


class BaseException extends \Exception
{
    /**
     * Optional data to be set
     * This will be shown to the user
     *
     * @var mixed
     */
    private $data;
    /**
     * This data will be shown only in debug mode
     *
     * @var mixed
     */
    private $debugData;
    /**
     * Type of the exception (from ExceptionCodes)
     *
     * @string
     */
    private $exceptionType;
    /**
     * The http status code for this exception
     *
     * @var
     */
    protected $httpCode;

    /**
     * BaseException constructor.
     *
     * @param string $exceptionType exception type constant as defined in ExceptionCodes
     * @param null   $data          data about the exception to be returned
     * @param null   $debugData     debug data about the exception
     */
    public function __construct($exceptionType, $data = null, $debugData = null)
    {
        parent::__construct(ExceptionCodes::getExceptionMessage($exceptionType));
        $this->exceptionType = $exceptionType;
        $this->data          = $data;
        $this->debugData     = $debugData;
    }

    /**
     * Get the log statement for this exception
     *
     * @param string $tag
     *
     * @return string
     */
    public function getLogStatement($tag = 'NO-TAG')
    {
        $type     = $this->exceptionType;
        $data     = json_encode($this->data);
        $debug    = json_encode($this->debugData);
        $message  = $this->getMessage();
        $httpCode = $this->httpCode;

        $user    = '[anon]';
        $userObj = AppHelpers::loggedInUser();
        if ($userObj != null) {
            $user = '[' . $userObj->debugName() . ']';
        }

        return "[Exception] [tag=${tag}] ${user} ${httpCode} ${type} msg=[${message}] data=[${data}] debug=[${debug}]";
    }

    /**
     * Log the exception to laravel log
     *
     * @param string $tag
     */
    public function logException($tag = '')
    {
        Log::warning($this->getLogStatement($tag));
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDebugData()
    {
        return $this->debugData;
    }

    /**
     * @param mixed $debugData
     *
     * @return $this
     */
    public function setDebugData($debugData)
    {
        $this->debugData = $debugData;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getExceptionType()
    {
        return $this->exceptionType;
    }

    /**
     * @param mixed $exceptionType
     *
     * @return $this
     */
    public function setExceptionType($exceptionType)
    {
        $this->exceptionType = $exceptionType;

        return $this;
    }

    /**
     * Set the message
     *
     * @param $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param mixed $httpCode
     *
     * @return $this
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;

        return $this;
    }
}
