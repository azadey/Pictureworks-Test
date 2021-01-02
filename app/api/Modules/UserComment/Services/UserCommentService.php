<?php
namespace Api\Modules\UserComment\Services;

use Api\Exceptions\ValidationException;
use Api\Modules\UserComment\Repositories\UserCommentRepository;
use Illuminate\Database\Eloquent\Model;

class UserCommentService
{
    /**
     * @var UserCommentRepository
     */
    private $userCommentRepository;

    /**
     * UserCommentService constructor.
     * @param UserCommentRepository $userCommentRepository
     */
    public function __construct(UserCommentRepository $userCommentRepository)
    {
        $this->userCommentRepository = $userCommentRepository;
    }

    /**
     * @param $id
     * @return Model|mixed|null
     */
    public function getUserComment($id)
    {
        return $this->userCommentRepository->find($id);
    }

    /**
     * @param $data
     * @return Model
     * @throws ValidationException
     */
    public function createUserComment($data)
    {

        if ($data["password"] != "720DF6C2482218518FA20FDC52D4DED7ECC043AB")
        {
            throw new ValidationException("Invalid Password");
        }

        return $this->userCommentRepository->create([
            "name"      => $data["name"],
            "comments"  => $data["comments"]
        ]);
    }

    /**
     * @param $id
     * @param $data
     * @return bool
     * @throws ValidationException
     */
    public function updateUserComment($id, $data)
    {
        $userComment = $this->userCommentRepository->find($id);

        if (empty($userComment))
        {
            throw new ValidationException("User comment not found.");
        }

        return $this->userCommentRepository->update($userComment, [
            "name"      => $data["name"],
            "comments"  => $data["comments"]
        ]);
    }

    /**
     * @param $id
     * @throws ValidationException
     */
    public function deleteUserComment($id)
    {
        $userComment = $this->userCommentRepository->find($id);

        if (empty($userComment))
        {
            throw new ValidationException("User comment not found.");
        }

        $this->userCommentRepository->delete($userComment);
    }
}
