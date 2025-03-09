<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\UserServiceProfileRequest;
use App\Http\Requests\v1\User\UserServiceRequest;
use App\Http\Resources\v1\ServiceResource;
use App\Models\Service;
use App\ModelServices\Service\ServiceHandler;
use Illuminate\Http\JsonResponse;

class AdminServiceController extends Controller
{
    protected string $resource = ServiceResource::class;

    public function __construct(
        private ServiceHandler $serviceHandler
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $services = $this->serviceHandler->getServices(["user", "profile"]);
        return $this->ok($this->paginate($services));
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): JsonResponse
    {
        $service->load("user", "items", "dayOffs", "profile");
        return $this->ok($service);
    }

    public function suspend(Service $service): JsonResponse
    {
        $service = $this->serviceHandler->suspend($service);
        return $this->ok($service);
    }

    public function unsuspend(Service $service): JsonResponse
    {
        $service = $this->serviceHandler->suspend($service, false);
        return $this->ok($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserServiceRequest $request, Service $service): JsonResponse
    {
        $data = $request->all();
        $service->update($data);
        return $this->ok($service);
    }

    public function updateProfile(UserServiceProfileRequest $request, Service $service): JsonResponse
    {
        $service->load("profile");
        $profile = $service->profile;
        $profile->update($request->validated());
        return $this->ok($service);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): JsonResponse
    {
        $service->delete();
        return $this->deleted();
    }
}
