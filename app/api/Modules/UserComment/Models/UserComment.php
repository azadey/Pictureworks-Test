<?php
namespace Api\Modules\UserComment\Models;

use Api\Core\Base\BaseModel;
use Database\Factories\UserCommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserComment extends BaseModel
{

    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserCommentFactory::new();
    }
}
