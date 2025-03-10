<?php

namespace Front;

use App\Enums\ServiceStatus;
use App\Enums\ShowStatus;
use App\Models\Booking;
use App\Models\LadderOrder;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\ServiceProfile;
use Tests\UserTest;

class FrontServiceItemsTest extends UserTest
{
    public function test_index_should_return_available_service_items()
    {
        $item1 = $this->makeItem();
        $item2 = ServiceItem::factory()->create();
        $res = $this->getJson(route("v1.front.service-items.index"));
        $res->assertSee($item1->name);
        $res->assertDontSee($item2->name);
    }

    public function test_index_should_return_ladder_items_before_normal_items()
    {
        $item1 = $this->makeItem([
            "created_at" => now()->subDay(),
        ]);
        $item2 = $this->makeItem([
            "created_at" => now()->subDays(2),
        ]);
        $item3 = $this->makeItem([
            "created_at" => now()->subDays(3),
        ]);
        LadderOrder::factory()->for($item2, "item")->create([
            "status" => ShowStatus::Showing->value,
        ]);
        LadderOrder::factory()->for($item3, "item")->create([
            "status" => ShowStatus::Waiting->value
        ]);
        $this->withoutExceptionHandling();
        $res = $this->getJson(route("v1.front.service-items.index"));
        $data = $res->json();
        $this->assertEquals($data[0]["name"], $item2["name"]);
        $this->assertEquals($data[1]["name"], $item1["name"]);
        $this->assertEquals($data[2]["name"], $item3["name"]);
    }

    private function makeItem(array $data = []): ServiceItem
    {
        $profile = ServiceProfile::factory()->state([
            "state_id" => $this->user->profile->state->id,
            "city_id" => $this->user->profile->city->id,
        ]);
        $service = Service::factory()->has($profile, "profile")->create([
            "status" => ServiceStatus::Complete->value
        ]);
        return ServiceItem::factory()->for($service)->create($data);
    }
}
