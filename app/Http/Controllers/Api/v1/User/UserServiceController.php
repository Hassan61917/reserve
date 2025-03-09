<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\User\UserServiceRequest;
use App\Http\Resources\v1\ServiceResource;
use App\Models\Service;
use App\ModelServices\Service\ServiceHandler;
use Illuminate\Http\JsonResponse;

class UserServiceController extends AuthUserController
{
    protected string $resource = ServiceResource::class;

    public function __construct(
        public ServiceHandler $serviceHandler
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $services = $this->serviceHandler->getServicesFor($this->authUser(), ["profile"]);
        return $this->ok($this->paginate($services));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserServiceRequest $request): JsonResponse
    {
        $data = $request->all();
        $service = $this->serviceHandler->make($this->authUser(), $data);
        return $this->ok($service);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): JsonResponse
    {
        $service->load("profile", "dayOffs", "items")->loadCount("items");
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): JsonResponse
    {
        $service->delete();
        return $this->deleted();
    }
}
