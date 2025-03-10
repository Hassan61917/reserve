<?php

namespace Admin;

use App\Models\Ban;
use App\Models\User;
use Tests\AdminTest;

class BannedUserTest extends AdminTest
{
    public function test_store_should_banned_user()
    {
        $data = Ban::factory()->raw();
        $this->withoutExceptionHandling();
        $this->postJson(route('bans.store'), $data);
        $this->assertDatabaseHas('bans', [
            "admin_id" => $this->user->id,
            "user_id" => $data['user_id']
        ]);
    }

    public function test_store_should_not_banned_user_if_already_is_banned()
    {
        $user = User::factory()->create();
        $data = Ban::factory()->raw(['user_id' => $user->id]);
        $this->postJson(route('bans.store'), $data);
        $this->postJson(route('bans.store'), $data);
        $this->assertDatabaseCount('bans', 1);
    }

    public function test_store_should_throw_error_user_tries_to_banned_an_admin()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $data = Ban::factory()->raw(['user_id' => $admin->id]);
        $res = $this->postJson(route('bans.store'), $data);
        $res->assertStatus(422);
        $this->assertDatabaseEmpty('bans');
    }
}
