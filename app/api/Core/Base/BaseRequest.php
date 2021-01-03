<?php

namespace Api\Core\Base;

use Api\Exceptions\InvariantViolationException;
use Api\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;


abstract class BaseRequest extends FormRequest
{
    /**
     * Validation rules
     *
     * @return array
     */
    public abstract function rules();

    /**
     * Get an array of field name mappings to use.
     *
     * This is a map from the field name defined in the request
     * to desired field name. Field names will be renamed in the response of
     * validAll
     *
     * @return array
     */
    protected function fieldNameMappings()
    {
        return [];
    }

    /**
     * Override for business logic checks.
     * Function called if all other validations pass
     *
     * @return null|string|array
     */
    protected function businessValidations()
    {
        return null;
    }

    /**
     * Validate hook called by laravel
     *
     * @override
     */
    public function validateResolved()
    {
        parent::validateResolved();
        $errors = $this->businessValidations();

        if ($errors != null) {
            throw new \Exception($errors);
        }
    }

    /**
     * Always authorize; permissions checks done elsewhere
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get validation data
     *
     * @return array
     */
    public function validationData()
    {
        $data = parent::validationData();

        // add 'form' as a validation param so we can have generic validators attached to this
        $data['form'] = 'FORM_PLACEHOLDER';

        return $data;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator->errors()->toArray());
    }

    /**
     * Get all the valid keys as defined in rules
     *
     * @param array $except
     *
     * @return array
     */
    public function validKeys($except = [])
    {
        $out = [];
        foreach ($this->rules() as $key => $value) {
            // ignore keys with a * (like arrayName.*)
            if (strstr($key, '*') !== false) {
                continue;
            }

            // ignore keys in except
            if (in_array($key, $except)) {
                continue;
            }

            $out[] = $key;
        }

        return $out;
    }

    /**
     * Like $request->all() but returns only fields
     * which have been defined in rules
     *
     * @param array $except
     *
     * @return array
     * @throws InvariantViolationException
     */
    public function validAll($except = [])
    {
        $obj = $this->only($this->validKeys($except));

        // $obj will have 'null' set as missing fields. This is not what we want
        foreach ($obj as $key => $value) {
            if (!$this->has($key)) {
                unset($obj[$key]);
            }
        }

        // rename keys
        foreach ($this->fieldNameMappings() as $originalName => $newName) {
            if (isset($obj[$originalName])) {
                if (isset($obj[$newName])) {
                    throw new InvariantViolationException("Field $newName already exists in request");
                }

                $obj[$newName] = $obj[$originalName];
                unset($obj[$originalName]);
            }
        }

        return $obj;
    }

    /**
     * Get all the valid fields that are present in the given fields array
     *
     * @param array $fields
     *
     * @return array
     */
    public function validOnly($fields)
    {
        $obj = $this->validAll();

        // $obj will have 'null' set as missing fields. This is not what we want
        foreach ($obj as $key => $value) {
            if (!in_array($key, $fields)) {
                unset($obj[$key]);
            }
        }

        return $obj;
    }

    /**
     * Build a validator for validating a value in array
     *
     * @param $array
     *
     * @return string
     */
    protected function validateArr($array)
    {
        return 'in:' . implode(',', $array);
    }

    /**
     * Message to show for in array validation failures
     *
     * @param array $arr
     *
     * @return string
     */
    protected function inArrayMessage(array $arr)
    {
        return 'Invalid value. Value must be one of ' . implode(', ', $arr);
    }
}
