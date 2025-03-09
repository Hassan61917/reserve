<?php

namespace App\ModelServices\Service;

use App\Enums\ServiceStatus;
use App\Exceptions\ModelException;
use App\Models\Service;
use App\Models\ServiceDayoff;
use App\Models\ServiceItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceHandler
{
    public function getServices(array $relations = [])
    {
        return Service::query()->with($relations);
    }

    public function getServicesFor(User $user, array $relations = []): HasMany
    {
        return $user->services()->with($relations);
    }

    public function getAvailableService(Carbon $carbon, ?User $user = null)
    {
        return Service::available($carbon, $user)->with("profile", "user");
    }

    public function make(User $user, array $data): Service
    {
        $title = $data["title"];
        if ($user->services()->where("title", "LIKE", "%$title%")->exists()) {
            throw new ModelException("similar services already exists");
        }
        $service = $user->services()->create($data);
        $service->profile()->create([
            "state_id" => $user->profile->state_id,
            "city_id" => $user->profile->city_id
        ]);
        return $service;
    }

    public function addDayOff(Service $service, array $data): ServiceDayoff
    {
        $class = $service;
        if (array_key_exists('item_id', $data)) {
            $class = $this->findItem($data["item_id"]);
        }
        return $class->addDayOff($data);
    }

    public function findService(int $id): Service
    {
        return Service::findOrFail($id);
    }

    public function findItem(int $id): ServiceItem
    {
        return ServiceItem::findOrFail($id);
    }

    public function suspend(Service $service, bool $suspend = true): Service
    {
        if ($service->status == ServiceStatus::Draft->value) {
            return $service;
        }
        $status = $suspend ? ServiceStatus::Suspend : ServiceStatus::Complete;
        return $this->updateStatus($service, $status);
    }

    public function updateStatus(Service $service, ServiceStatus $status): Service
    {
        $service->update([
            "status" => $status->value
        ]);
        return $service;
    }


}
