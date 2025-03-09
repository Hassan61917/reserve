<?php

namespace App\ModelServices\Service;

use App\Models\Service;
use App\Models\ServiceItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServiceItemHandler
{
    public function getItems(array $relations = []): Builder
    {
        return ServiceItem::query()->with($relations);
    }

    public function getItemsFor(Service $service, array $relations = []): HasMany
    {
        return $service->items()->with($relations);
    }

    public function create(Service $service, array $data): ServiceItem
    {
        if (!$service->isCompleted()) {
            throw new HttpException(422, "service is not completed");
        }
        $name = $data['name'];
        if ($service->items()->where("name", "LIKE", "%$name%")->exists()) {
            throw new HttpException(422, "Service item already exists");
        }
        return $service->items()->create($data);
    }

    public function update(ServiceItem $serviceItem, array $data): ServiceItem
    {
        $serviceItem->update($data);
        return $serviceItem;
    }
}
