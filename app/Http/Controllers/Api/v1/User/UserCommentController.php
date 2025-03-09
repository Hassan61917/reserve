<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Resources\v1\CommentResource;
use App\Models\Comment;
use App\ModelServices\Social\CommentService;
use Illuminate\Http\JsonResponse;

class UserCommentController extends AuthUserController
{
    protected string $resource = CommentResource::class;
    protected ?string $ownerRelation = "post";

    public function __construct(
        private CommentService $commentService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $comments = $this->commentService->getPostsComments($this->authUser(), ["post"]);
        return $this->ok($this->paginate($comments));
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment): JsonResponse
    {
        $comment->load(["user", "post", "reply"]);
        return $this->ok($comment);
    }

}
