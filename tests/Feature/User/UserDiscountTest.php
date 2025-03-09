<?php

namespace Tests\Feature\User;

use App\Models\Discount;
use App\Models\Service;
use App\Models\ServiceItem;
use Tests\UserTest;

class UserDiscountTest extends UserTest
{
    public function test_store_user_only_can_create_discount_for_his_owns_services()
    {
        $discount = Discount::factory()->raw();
        $res = $this->postJson(route('v1.user.discounts.store'), $discount);
        $res->assertStatus(422);
    }

    public function test_store_user_only_can_create_discount_for_his_owns_service_items()
    {
        $service = Service::factory()->for($this->user)->create();
        $discount = Discount::factory()->for($service)->raw();
        $res = $this->postJson(route('v1.user.discounts.store'), $discount);
        $res->assertStatus(422);
    }

    public function test_store_user_can_create_discount()
    {
        $service = Service::factory()->for($this->user)->create();
        $item = ServiceItem::factory()->for($service)->create();
        $discount = Discount::factory()->for($service)->for($item, "item")->raw();
        $this->postJson(route('v1.user.discounts.store'), $discount);
        $this->assertDatabaseCount("discounts",1 );
    }
}
