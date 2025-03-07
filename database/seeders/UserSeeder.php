<?php

namespace Database\Seeders;

use App\Models\Role;
use App\ModelServices\User\UserService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        foreach ($roles as $role) {
            $this->createUser($role);
        }
    }

    private function createUser(Role $role): void
    {
        $this->userService->create([
            "email" => "$role@gmail.com",
            "password" => Hash::make('password'),
        ], $role);
    }
}
