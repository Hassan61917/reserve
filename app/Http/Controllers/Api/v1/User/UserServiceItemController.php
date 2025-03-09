<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\User\UserServiceItemRequest;
use App\Http\Resources\v1\ServiceItemResource;
use App\Models\Service;
use App\Models\ServiceItem;
use App\ModelServices\Service\ServiceItemHandler;
use Illuminate\Http\JsonResponse;

class UserServiceItemController extends AuthUserController
{
    protected string $resource = ServiceItemResource::class;
    public function __construct(
        private ServiceItemHandler $itemHandler,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Service $service): JsonResponse
    {
        $items = $this->itemHandler->getItemsFor($service)->withCount("dayOffs");
        return $this->ok($this->paginate($items));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Service $service, UserServiceItemRequest $request): JsonResponse
    {
        $data = $request->validated();
        $item = $this->itemHandler->create($service, $data);
        return $this->ok($item);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service, ServiceItem $item): JsonResponse
    {
        $item->load("service", "dayOffs")->loadCount("bookings");
        return $this->ok($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Service $service, UserServiceItemRequest $request, ServiceItem $item): JsonResponse
    {
        $data = $request->validated();
        $item->update($data);
        return $this->ok($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service, ServiceItem $item): JsonResponse
    {
        $item->delete();
        return $this->deleted();
    }


}
