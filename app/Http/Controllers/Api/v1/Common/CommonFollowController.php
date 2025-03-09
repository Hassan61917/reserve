<?php

namespace App\Http\Controllers\Api\v1\Common;

use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\Common\CommonFollowRequest;
use App\Http\Resources\v1\FollowResource;
use App\ModelServices\Social\FollowService;
use Illuminate\Http\JsonResponse;

class CommonFollowController extends AuthUserController
{
    protected string $resource = FollowResource::class;

    public function __construct(
        public FollowService $followService
    )
    {
    }

    public function index(): JsonResponse
    {
        $requests = $this->followService->getMyRequests($this->authUser());
        return $this->ok($this->paginate($requests));
    }

    public function follow(CommonFollowRequest $request): JsonResponse
    {
        $data = $request->validated();
        $follow = $this->followService->follow($this->authUser(), $data["page_id"]);
        return $this->ok($follow);
    }

    public function unfollow(CommonFollowRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->followService->unfollow($this->authUser(), $data["page_id"]);
        return $this->message("unFollowed");
    }

}
