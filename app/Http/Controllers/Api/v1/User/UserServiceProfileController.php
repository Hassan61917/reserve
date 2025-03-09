<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Enums\ServiceStatus;
use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\User\UserServiceProfileRequest;
use App\Http\Resources\v1\ServiceProfileResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class UserServiceProfileController extends AuthUserController
{
    protected ?string $ownerRelation = "service";

    public function index(Service $service): JsonResponse
    {
        $profile = $service->profile;
        return $this->ok($profile, ServiceProfileResource::make($profile));
    }

    public function update(Service $service, UserServiceProfileRequest $request): JsonResponse
    {
        $profile = $service->profile;
        $profile->update($request->validated());
        $service->update(["status" => ServiceStatus::Complete]);
        return $this->ok($profile, ServiceProfileResource::make($profile));
    }
}
