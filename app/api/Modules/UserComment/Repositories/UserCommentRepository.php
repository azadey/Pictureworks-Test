<?php
namespace Api\Modules\UserComment\Repositories;

use Api\Core\Base\BaseRepository;
use Api\Modules\UserComment\Models\UserComment;

class UserCommentRepository extends BaseRepository
{

    /**
     * @return string|void
     */
    public function model()
    {
        return UserComment::class;
    }
}
