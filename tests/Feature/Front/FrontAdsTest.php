<?php

namespace Front;

use App\Enums\ShowStatus;
use App\Models\AdsOrder;
use Tests\UserTest;

class FrontAdsTest extends UserTest
{
    public function test_index_should_return_showing_ads()
    {
        $order1 = $this->makeOrder(ShowStatus::Waiting);
        $order2 = $this->makeOrder(ShowStatus::Showing);
        $order3 = $this->makeOrder(ShowStatus::Completed);
        $res = $this->getJson(route("v1.front.ads.index"));
        $res->assertSee($order2->status);
        $res->assertDontSee($order1->status);
        $res->assertDontSee($order3->status);
    }
    private function makeOrder(ShowStatus $status)
    {
        return AdsOrder::factory()->create([
            "status" => $status->value
        ]);
    }
}
