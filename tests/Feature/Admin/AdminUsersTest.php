<?php

namespace Admin;

use App\Models\Profile;
use App\Models\User;
use Tests\AdminTest;

class AdminUsersTest extends AdminTest
{
    public function test_store_should_create_admin_user_if_has_is_admin()
    {
        $data = [
            "email" => "admin@gmail.com",
            "password" => "password",
            "is_admin" => true
        ];
        $this->postJson(route("users.store"), $data);
        $this->assertDatabaseHas("users", [
            "email" => "admin@gmail.com",
            "is_admin" => true
        ]);
    }

    public function test_make_admin_should_set_user_to_admin()
    {
        $user = User::factory()->create();
        $this->assertFalse($user->is_admin);
        $this->postJson(route('users.set-admin',$user));
        $this->assertTrue($user->fresh()->is_admin);
    }

    public function test_delete_should_delete_profile_is_user_is_deleted()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->for($user)->create();
        $this->deleteJson(route("users.destroy", $user));
        $this->assertDatabaseMissing("users", [
            "user_id" => $user->id,
        ]);
        $this->assertDatabaseMissing("profiles", [
            "id" => $profile->id
        ]);
    }
}
