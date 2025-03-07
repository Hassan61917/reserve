<?php

namespace App\ModelServices\User;

use App\Events\UserRegistered;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;

class AuthService
{
    public function __construct(
        private UserService $userService
    )
    {
    }

    public function register(array $data): User
    {
        $role = $this->getDefaultRole();
        $user = $this->userService->create($data, $role);
        UserRegistered::dispatch($user);
        return $user;
    }

    public function login(array $data): User
    {
        if (!auth()->attempt($data)) {
            throw new AuthenticationException("invalid credentials");
        }
        return User::firstWhere("email", $data["email"]);
    }

    public function logout(): void
    {
        auth()->user()->currentAccessToken()->delete();
    }

    private function getDefaultRole(): Role
    {
        return Role::where("title", "user")->first();
    }
}
