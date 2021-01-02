<?php
namespace Api\Modules\UserComment\Requests;

use Api\Core\Base\BaseRequest;

class UserCommentRequest extends BaseRequest
{

    public function rules()
    {
        return [
            "name"            => [
                "required",
                "max:255",
                "string",
            ],
            "comments"          => [
                "required",
                "string",
            ],
            "password"          => [
                "required",
                "string"
            ]
        ];
    }
}
