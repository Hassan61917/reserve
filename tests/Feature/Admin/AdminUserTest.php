<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Tests\AdminTest;

class AdminUserTest extends AdminTest
{
    public function test_index_should_return_all_users()
    {
        $user1 = $this->makeUser("user");
        $res = $this->getJson(route("v1.admin.users.index"));
        $res->assertSee($user1->email);
    }

    public function test_store_should_store_new_user_with_any_role()
    {
        $role = $this->makeRole("manager");
        $email = "user@gmail.com";
        $data = [
            "role_id" => $role->id,
            "email" => $email,
            "password" => "password",
        ];
        $this->postJson(route("v1.admin.users.store"), $data);
        $this->assertDatabaseHas("users", ["email" => $email,]);
        $this->assertCount(1, $role->users);
    }

    public function test_addRole_should_add_role_to_user()
    {
        $role = $this->makeRole("manager");
        $user = User::factory()->create();
        $this->assertFalse($user->hasRole($role->title));
        $this->postJson(route('v1.admin.users.add-role', [$user, $role]));
        $this->assertTrue($user->hasRole($role->title));
    }

    public function test_addRole_user_can_not_add_role_to_him_self()
    {
        $role = $this->makeRole("manager");
        $user = $this->user;
        $res = $this->postJson(route('v1.admin.users.add-role', [$user, $role]));
        $res->assertStatus(403);
        $this->assertFalse($user->hasRole($role->title));
    }

    public function test_addRole_should_remove_role_from_user()
    {
        $role = $this->makeRole("manager");
        $user = $this->makeUser("manager");
        $this->assertTrue($user->hasRole($role->title));
        $this->deleteJson(route('v1.admin.users.remove-role', [$user, $role]));
        $this->assertFalse($user->hasRole($role->title));
    }

    public function test_addRole_user_can_not_remove_role_from_him_self()
    {
        $role = $this->makeRole("admin");
        $user = $this->user;
        $this->assertTrue($user->hasRole($role->title));
        $res = $this->deleteJson(route('v1.admin.users.remove-role', [$user, $role]));
        $res->assertStatus(403);
        $this->assertTrue($user->hasRole($role->title));
    }
}
