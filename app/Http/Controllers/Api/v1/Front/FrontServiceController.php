<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ServiceResource;
use App\Models\Service;
use App\ModelServices\Service\ServiceHandler;
use Illuminate\Http\JsonResponse;

class FrontServiceController extends Controller
{
    protected string $resource = ServiceResource::class;

    public function __construct(
        private ServiceHandler $serviceHandler
    )
    {
    }

    public function index(): JsonResponse
    {
        $services = $this->serviceHandler->getAvailableService(now(), auth()->user());
        return $this->ok($this->paginate($services));
    }

    public function show(Service $service): JsonResponse
    {
        $service->load("user", "profile", "items");
        return $this->ok($service);
    }
}
