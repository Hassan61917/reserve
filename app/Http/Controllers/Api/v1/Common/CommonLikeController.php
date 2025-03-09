<?php

namespace App\Http\Controllers\Api\v1\Common;

use App\Enums\LikeableModel;
use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\Common\CommonLikeRequest;
use App\ModelServices\Social\LikeService;
use App\Utils\EnumHelper;
use Illuminate\Http\JsonResponse;

class CommonLikeController extends AuthUserController
{
    public function __construct(
        private LikeService $likeService
    )
    {
    }

    public function like(CommonLikeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $model = $this->getModel($data);
        $this->likeService->like($this->authUser(), $model);
        return $this->message("liked successfully");
    }
    public function dislike(CommonLikeRequest $request): JsonResponse
    {
        $data = $request->validated();
        $model = $this->getModel($data);
        $this->likeService->disLike($this->authUser(), $model);
        return $this->message("liked successfully");
    }
    private function getModel(array $data)
    {
        $model = EnumHelper::getValue(LikeableModel::class, $data['model'])->value;
        return $model::find($data['model_id']);
    }
}
