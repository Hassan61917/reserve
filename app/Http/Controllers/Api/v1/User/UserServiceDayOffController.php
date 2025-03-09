<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\User\UserServiceDayOffRequest;
use App\Http\Resources\v1\ServiceDayOffResource;
use App\Models\Service;
use App\Models\ServiceDayoff;
use App\ModelServices\Service\ServiceHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserServiceDayOffController extends AuthUserController
{
    protected string $resource = ServiceDayOffResource::class;
    public function __construct(
        private ServiceHandler $serviceHandler,
    ) {}

    public function index(Service $service): JsonResponse
    {
        $dayOffs = $service->dayOffs();
        return $this->ok($this->paginate($dayOffs));
    }

    public function store(Service $service, UserServiceDayOffRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (!$this->hasItems($data)) {
            return $this->error(422, "you should select at least one item");
        }
        $dayOff = $this->serviceHandler->addDayOff($service, $data);
        return $this->ok($dayOff);
    }

    public function show(Service $service, ServiceDayoff $dayOff): JsonResponse
    {
        $dayOff->load("item");
        return $this->ok($dayOff);
    }


    public function update(Service $service, Request $request, ServiceDayoff $dayOff): JsonResponse
    {
        $dayOff->update($request->validated());
        return $this->ok($dayOff);
    }


    public function destroy(Service $service, ServiceDayoff $dayOff): JsonResponse
    {
        $dayOff->delete();
        return $this->deleted();
    }

    private function hasItems(array $data): bool
    {
        $keys = ["in_week", "in_month", "date"];
        foreach ($keys as $key) {
            if (array_key_exists($key, $data) && $data[$key]) {
                return true;
            }
        }
        return false;
    }
}
