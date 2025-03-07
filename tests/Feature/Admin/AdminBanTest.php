<?php

namespace Admin;

use App\Models\Ban;
use Tests\AdminTest;

class AdminBanTest extends AdminTest
{
    public function test_index_should_return_all_banned_users()
    {
        $ban = Ban::factory()->create();
        $res = $this->getJson(route("v1.admin.bans.index"));
        $res->assertSee($ban->reason);
    }

    public function test_ban_should_unban_user()
    {
        $user = $this->makeUser("user");
        $ban = Ban::factory()->for($user)->create();
        $this->postJson(route("v1.admin.user.unban", $user));
        $this->assertTrue($ban->fresh()->finished);
    }

    public function test_ban_should_ban_user()
    {
        $user = $this->makeUser("user");
        $data = $this->getBanData();
        $this->withoutExceptionHandling();
        $this->postJson(route("v1.admin.user.ban", $user), $data);
        $this->assertDatabaseHas("bans", [
            ...$data,
            "user_id" => $user->id,
            "admin_id" => $this->user->id
        ]);
    }

    public function test_ban_should_return_error_if_user_is_already_banned()
    {
        $user = $this->makeUser("user");
        $data = $this->getBanData();
        $this->postJson(route("v1.admin.user.ban", $user), $data);
        $res = $this->postJson(route("v1.admin.user.ban", $user), $data);
        $this->assertDatabaseCount("bans", 1);
        $res->assertStatus(422);
    }

    public function test_ban_should_double_duration_if_user_was_banned_for_same_reason()
    {
        $user = $this->makeUser("user");
        $duration = 1;
        $reason = "reason";
        Ban::factory()->for($user)->create([
            "reason" => $reason,
            "finished" => true,
            "duration" => $duration
        ]);
         Ban::factory()->for($user)->create([
            "reason" => $reason,
            "finished" => true,
            "duration" => $duration * 2,
            "created_at" => now()->addDay()
        ]);
        $data = $this->getBanData($reason, $duration);
        $this->withoutExceptionHandling();
        $this->postJson(route("v1.admin.user.ban", $user), $data);
        $this->assertDatabaseHas("bans", [
            ...$data,
            "duration" => $duration * 4,
        ]);

    }

    public function test_ban_should_return_error_if_user_is_admin()
    {
        $user = $this->makeUser("admin");
        $data = $this->getBanData();
        $res = $this->postJson(route("v1.admin.user.ban", $user), $data);
        $res->assertStatus(403);
    }

    public function test_ban_should_return_error_if_user_is_him_self()
    {
        $user = $this->user;
        $data = $this->getBanData();
        $res = $this->postJson(route("v1.admin.user.ban", $user), $data);
        $res->assertStatus(403);
    }


    public function getBanData(?string $reason = null, ?int $duration = null): array
    {
        return [
            "reason" => $reason ?? "reason",
            "duration" => $duration ?? 1,
        ];
    }
}
