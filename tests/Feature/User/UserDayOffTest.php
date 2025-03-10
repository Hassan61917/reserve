<?php

namespace Tests\Feature\User;

use App\Models\Service;
use App\Models\ServiceDayoff;
use Tests\UserTest;

class UserDayOffTest extends UserTest
{
    public function test_store_should_not_store_day_off_for_other_services()
    {
        $service = Service::factory()->create();
        $data = ServiceDayOff::factory()->raw();
        $res = $this->postJson(route("user.service.dayoffs.store", $service), $data);
        $res->assertStatus(403);
    }
    public function test_store_should_store_day_off_for_service()
    {
        $service = Service::factory()->for($this->user)->create();
        $data = ServiceDayOff::factory()->for($service)->raw();
        $this->withoutExceptionHandling();
        $res = $this->postJson(route("user.service.dayoffs.store", $service), $data);
        $this->assertDatabaseHas("service_dayoffs", $data);
    }
    public function test_store_should_not_store_repeated_day_off()
    {
        $service = Service::factory()->for($this->user)->create();
        $data = ServiceDayOff::factory()->for($service)->raw();
        $this->withoutExceptionHandling();
        $this->postJson(route("user.service.dayoffs.store", $service), $data);
        $this->postJson(route("user.service.dayoffs.store", $service), $data);
        $this->assertDatabaseCount("service_dayoffs", 1);
    }
}
