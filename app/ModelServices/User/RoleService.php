<?php

namespace App\ModelServices\User;

use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class RoleService
{
    public function make(array $data)
    {
        return Role::create($data);
    }

    public function getAll(array $relations = []): Builder
    {
        return Role::query()->with($relations);
    }

    public function find(string $name): ?Role
    {
        return Role::where("name", $name)->first();
    }
}
