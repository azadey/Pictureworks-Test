<?php
namespace Api\Modules\UserComment;

use Api\Core\Base\BaseController;
use Api\Exceptions\ValidationException;
use Api\Modules\UserComment\Requests\UserCommentRequest;
use Api\Modules\UserComment\Services\UserCommentService;
use Illuminate\Http\JsonResponse;

class UserCommentController extends BaseController
{
    /**
     * @var UserCommentService
     */
    private $userCommentService;

    /**
     * UserCommentController constructor.
     * @param UserCommentService $userCommentService
     */
    public function __construct(UserCommentService $userCommentService)
    {
        $this->userCommentService = $userCommentService;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getUserComment($id)
    {
        return new JsonResponse($this->userCommentService->getUserComment($id));
    }

    /**
     * @param UserCommentRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function createUserComment(UserCommentRequest $request)
    {
        $data = $request->validated();
        $this->userCommentService->createUserComment($data);

        return new JsonResponse(["data" => "User Comment Successfully Created."]);
    }

    /**
     * @param $id
     * @param UserCommentRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function updateUserComment($id, UserCommentRequest $request)
    {
        $data = $request->validated();
        $this->userCommentService->updateUserComment($id, $data);

        return new JsonResponse(["data" => "User Comment Successfully Updated."]);
    }

    /**
     * @param $id
     * @return JsonResponse
     * @throws ValidationException
     */
    public function deleteUserComment($id)
    {
        $this->userCommentService->deleteUserComment($id);

        return new JsonResponse(["data" => "User Comment Successfully Deleted."]);
    }
}
