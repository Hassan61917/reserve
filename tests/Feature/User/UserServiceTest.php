<?php

namespace Tests\Feature\User;

use App\Models\Service;
use Tests\UserTest;

class UserServiceTest extends UserTest
{
    public function test_store_should_create_service()
    {
        $userId = $this->user->id;
        $data = Service::factory()->raw();
        $this->postJson(route("v1.user.services.store"), $data);
        $this->assertDatabaseHas("services", [
            "user_id" => $userId,
            "name" => $data["name"],
        ]);
    }

    public function test_store_should_not_create_service_if_exists()
    {
        $service = Service::factory()->for($this->user)->create();
        $data = Service::factory()->for($this->user)->raw(["title" => $service->title]);
        $this->postJson(route("v1.user.services.store"), $data)
            ->assertStatus(422);
    }

    public function test_store_should_create_profile_for_service_when_service_is_created()
    {
        $data = Service::factory()->raw(["user_id" => $this->user->id]);
        $this->postJson(route("v1.user.services.store"), $data);
        $this->assertDatabaseCount("service_profiles", 1);
    }

    public function test_update_should_update_service()
    {
        $service = Service::factory()->create(["user_id" => $this->user->id]);
        $data = [
            "name" => $service->name,
            "category_id" => $service->category_id,
            "description" => $service->description . " updated",
        ];
        $this->putJson(route("v1.user.services.update", $service), $data);
        $this->assertDatabaseHas("services", $data);
    }
}
