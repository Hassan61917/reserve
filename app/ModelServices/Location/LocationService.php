<?php

namespace App\ModelServices\Location;

use App\Models\City;
use App\Models\State;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class LocationService
{
    public function getStates(array $relations = []): Builder
    {
        return State::query()->with($relations);
    }

    public function makeState(array $data): State
    {
        return State::create($data);
    }

    public function getCities(array $relations = []): Builder
    {
        return City::query()->with($relations);
    }

    public function makeCity(array $data): City
    {
        return City::create($data);
    }

    public function getCityUsers(City $city, array $relations = []): Builder
    {
        return $this->getUsers()
            ->where("profiles.city_id", $city->id)
            ->with($relations);
    }

    public function getStateUsers(State $state, array $relations = []): Builder
    {
        return $this->getUsers()
            ->where("profiles.state_id", $state->id)
            ->with($relations);
    }

    private function getUsers(): Builder
    {
        return User::query()
            ->select("users.*")
            ->join("profiles", "users.id", "=", "profiles.user_id");
    }
}
