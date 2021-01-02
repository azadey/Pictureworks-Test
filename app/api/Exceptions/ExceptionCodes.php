<?php

namespace Api\Exceptions;

class ExceptionCodes
{
    const MESSAGE_SERVER_ERROR = 'Something has gone wrong. If it persists please notify the problem';

    // all exceptions in the format name => description
    protected static $EXCEPTIONS = [

        /**
         * 5XX errors
         */
        'CONFIGURATION_ERROR'      => ExceptionCodes::MESSAGE_SERVER_ERROR . ' E_CFG',
        'INVARIANT_VIOLATION'      => ExceptionCodes::MESSAGE_SERVER_ERROR . ' E_INV',
        'SERVICE_UNAVAILABLE'      => 'Service is down for maintenance. Please try again later',

        // generic catch all server error
        'SERVER_ERROR'             => ExceptionCodes::MESSAGE_SERVER_ERROR,

        /**
         * 4XX errors
         */
        'NOT_FOUND'                => 'Invalid API endpoint',
        'VALIDATION_ERROR'         => 'Some of the fields are invalid',
        'FORBIDDEN'                => 'Insufficient permissions for this action',
        'UNAUTHORIZED'             => 'User has invalid credentials',
        'TOO_MANY_REQUESTS'        => 'Too many requests. Please wait for a while',

        // generic catch all client error
        'BAD_REQUEST'              => 'Bad Request',

        // user module
        'REGISTRATION_REQUIRED'    => 'User not registered. Please register.',
        'MOBILE_MISMATCH'          => 'Your mobile number does not match with our records. Please submit a request to update.',

        // policy module
        'POLICY_VERIFICATION_FAIL' => 'Given details does not match any policy.',
    ];

    // 5XX errors
    const CONFIGURATION_ERROR = 'CONFIGURATION_ERROR';
    const INVARIANT_VIOLATION = 'INVARIANT_VIOLATION';
    const SERVER_ERROR        = 'SERVER_ERROR';
    const SERVICE_UNAVAILABLE = 'SERVICE_UNAVAILABLE';

    // 4XX errors
    const TOO_MANY_REQUESTS = 'TOO_MANY_REQUESTS';
    const BAD_REQUEST       = 'BAD_REQUEST';
    const NOT_FOUND         = 'NOT_FOUND';
    const VALIDATION_ERROR  = 'VALIDATION_ERROR';
    const FORBIDDEN         = 'FORBIDDEN';
    const UNAUTHORIZED      = 'UNAUTHORIZED';

    // user errors
    const REGISTRATION_REQUIRED = 'REGISTRATION_REQUIRED';
    const MOBILE_MISMATCH       = 'MOBILE_MISMATCH';

    // policy errors
    const POLICY_VERIFICATION_FAIL = 'POLICY_VERIFICATION_FAIL';

    /**
     * Given the name of an exception object return the name
     *
     * @param $name
     *
     * @return string exception message
     */
    public static function getExceptionMessage($name)
    {
        return self::$EXCEPTIONS[$name];
    }

    /**
     * Given an HTTP code returns the default exception name
     *
     * @param $httpCode int http code
     *
     * @return string
     */
    public static function getDefaultErrorForHttpCode($httpCode)
    {
        if ($httpCode == 404) {
            return self::NOT_FOUND;
        }

        if ($httpCode >= 400 && $httpCode <= 499) {
            return self::BAD_REQUEST;
        }

        return self::SERVER_ERROR;
    }
}
