<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\UserServiceItemRequest;
use App\Http\Resources\v1\ServiceItemResource;
use App\Models\ServiceItem;
use App\ModelServices\Service\ServiceItemHandler;
use Illuminate\Http\JsonResponse;

class AdminServiceItemController extends Controller
{
    protected string $resource = ServiceItemResource::class;

    public function __construct(
        private ServiceItemHandler $itemHandler
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $items = $this->itemHandler->getItems(["service"]);
        return $this->ok($this->paginate($items));
    }

    public function show(ServiceItem $item): JsonResponse
    {
        $item->load("service", "dayOffs");
        return $this->ok($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserServiceItemRequest $request, ServiceItem $item): JsonResponse
    {
        $data = $request->validated();
        $item->update($data);
        return $this->ok($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceItem $item): JsonResponse
    {
        $item->delete();
        return $this->deleted();
    }

}
