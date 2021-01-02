<?php

namespace Api\Exceptions;

class ValidationException extends ClientException
{
    protected $httpCode = 422;

    /**
     * ValidationException constructor.
     *
     * @param array|string $errors
     * @param null         $debugData
     * @param null         $message
     */
    public function __construct($errors, $debugData = null, $message = null)
    {
        if (is_array($errors) == false && is_string($errors)) {
            $errors = ["form" => [$errors]];
        }

        if (is_array($errors)) {
            foreach ($errors as $key => $value) {
                if (!is_array($value)) {
                    $errors[$key] = [$value];
                }
            }
        }

        parent::__construct($errors, $debugData, ExceptionCodes::VALIDATION_ERROR);

        // set message
        if (! empty($errors)) {
            parent::setMessage('There are errors in ' . implode(', ', array_keys($errors)));
        }

        if ($message !== null) {
            parent::setMessage($message);
        }
    }
}
