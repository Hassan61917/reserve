<?php

namespace Database\Seeders;

use App\ModelServices\User\RoleService;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function __construct(
        private RoleService $roleService
    )
    {
    }

    protected array $roles = [
        "user", "admin"
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles as $role) {
            $this->roleService->make(["title" => $role]);
        }
    }
}
