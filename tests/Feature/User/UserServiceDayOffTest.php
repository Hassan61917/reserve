<?php

namespace Tests\Feature\User;

use App\Models\Service;
use App\Models\ServiceDayoff;
use Tests\UserTest;

class UserServiceDayOffTest extends UserTest
{
    public function test_store_should_not_store_day_off_for_other_services()
    {
        $service = Service::factory()->create();
        $data = ServiceDayOff::factory()->raw();
        $res = $this->postJson(route("v1.user.services.day-offs.store", $service), $data);
        $res->assertStatus(403);
    }

    public function test_store_should_not_store_if_has_not_valid_date()
    {
        $service = Service::factory()->for($this->user)->create();
        $data = [
            "in_week" => null,
            "in_month" => null,
            "date" => null,
        ];
        $this->postJson(route("v1.user.services.day-offs.store", $service), $data)
            ->assertStatus(422);
    }

    public function test_store_should_store_day_off()
    {
        $service = Service::factory()->for($this->user)->create();
        $data = [
            "in_week" => 6,
            "in_month" => null,
            "date" => null,
        ];
        $this->withoutExceptionHandling();
        $this->postJson(route("v1.user.services.day-offs.store", $service), $data);
        $this->assertDatabaseHas("service_dayoffs", $data);
    }

    public function test_store_should_not_store_repeated_day_off()
    {
        $service = Service::factory()->for($this->user)->create();
        ServiceDayOff::factory()->for($service)->create(["in_week" => 6]);
        $data = [
            "in_week" => 6,
            "in_month" => null,
            "date" => null,
        ];
        $this->postJson(route("v1.user.services.day-offs.store", $service), $data)
            ->assertStatus(422);
        $this->assertDatabaseCount("service_dayoffs", 1);
    }
}
