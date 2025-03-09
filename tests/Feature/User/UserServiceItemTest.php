<?php

namespace Tests\Feature\User;

use App\Enums\ServiceStatus;
use App\Models\Service;
use App\Models\ServiceItem;
use Tests\UserTest;

class UserServiceItemTest extends UserTest
{
    public function test_store_should_return_error_if_user_tries_to_add_item_for_others_services()
    {
        $service = Service::factory()->create();
        $data = ServiceItem::factory()->for($service)->raw();
        $res = $this->postJson(route("v1.user.service.items.store", $service), $data);
        $res->assertStatus(403);
    }

    public function test_store_should_not_store_item_if_service_is_not_completed()
    {
        $service = Service::factory()->for($this->user)->create();
        $data = ServiceItem::factory()->for($service)->raw();
        $res = $this->postJson(route("v1.user.service.items.store", $service), $data);
        $res->assertStatus(422);
    }

    public function test_store_should_add_item_to_service()
    {
        $service = Service::factory()->for($this->user)->create(["status" => ServiceStatus::Complete->value]);
        $data = ServiceItem::factory()->for($service)->raw();
        $this->withoutExceptionHandling();
        $this->postJson(route("v1.user.service.items.store", $service), $data);
        $this->assertDatabaseHas("service_items", [
            "service_id" => $service->id,
            "name" => $data["name"]
        ]);
    }
}
