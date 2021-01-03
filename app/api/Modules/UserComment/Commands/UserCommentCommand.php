<?php
namespace Api\Modules\UserComment\Commands;

use Api\Modules\UserComment\Requests\UserCommentRequest;
use Api\Modules\UserComment\Services\UserCommentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class UserCommentCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'user-comment:create';

    /**
     * @var string
     */
    protected $description = "Create a user comment";

    protected $userCommentService;
    /**
     * UserCommentCommand constructor.
     */
    public function __construct(UserCommentService $userCommentService)
    {
        parent::__construct();

        $this->userCommentService = $userCommentService;
    }

    /**
     * @param $name
     * @param $comments
     * @throws \Api\Exceptions\ValidationException
     */
    public function handle()
    {
        $name = $this->ask("What's your name ?");
        $comments = $this->ask("Write your comment");
        $password = '720DF6C2482218518FA20FDC52D4DED7ECC043AB';

        $validator = Validator::make([
            'name' => $name,
            'comments' => $comments,
            'password' => $password,
        ], [
            'name' => ['required', 'max:255'],
            'comments' => ['required'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            $this->info('Comment not created. See error messages below:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        $this->userCommentService->createUserComment([
            'name' => $name,
            'comments' => $comments,
            'password' => $password
        ]);

    }
}
