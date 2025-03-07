<?php

namespace App\ModelServices\User;

use App\Events\UserWasCreated;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class UserService
{

    public function getAll(array $relations = []): Builder
    {
        return User::query()->with($relations);
    }

    public function create(array $data, Role $role): User
    {
        $user = User::create($data);
        $this->addRole($user, $role);
        UserWasCreated::dispatch($user);
        return $user;
    }

    public function addRole(User $user, Role $role): void
    {
        if ($user->hasRole($role->title)) {
            return;
        }
        $user->roles()->attach($role);
    }

    public function removeRole(User $user, Role $role): void
    {
        if (!$user->hasRole($role->title)) {
            return;
        }
        $user->roles()->detach($role);
    }
}
