<?php

namespace Front;

use App\Enums\ServiceStatus;
use App\Models\Service;
use App\Models\ServiceProfile;
use Tests\UserTest;

class FrontServiceTest extends UserTest
{
    public function test_index_should_return_services_that_are_near_user_location()
    {
        $service1 = $this->createNearService();
        $service2 = $this->makeService();
        $this->withoutExceptionHandling();
        $res = $this->getJson(route('v1.front.services.index'));
        $res->assertSee($service1->name);
        $res->assertDontSee($service2->name);
    }

    public function test_index_should_return_completed_services()
    {
        $service1 = $this->createNearService([], ["status" => ServiceStatus::Draft->value]);
        $service2 = $this->createNearService([], ["status" => ServiceStatus::Complete->value]);
        $res = $this->getJson(route('v1.front.services.index'));
        $res->assertDontSee($service1->name);
        $res->assertSee($service2->name);
    }
    public function test_index_should_service_available_services()
    {
        $data = ["open_at"=>9, "close_at"=>10];
        $service1 = $this->createNearService($data);
        if (now()->hour < 9) {
            $this->travel(11)->hours();
        }
        $res = $this->getJson(route('v1.front.services.index'));
        $res->assertDontSee($service1->name);
        $service1 = $this->createNearService($data);
        $this->withoutExceptionHandling();
        $res = $this->getJson(route('v1.front.services.index'));
        $res->assertSee($service1->name);
    }
    private function makeService(array $profileData = [], array $serviceData = []): Service
    {
        if (empty($serviceData)) {
            $serviceData = ["status" => ServiceStatus::Complete->value];
        }
        return Service::factory()
            ->has(ServiceProfile::factory()->state($profileData), "profile")
            ->create($serviceData);
    }
    private function createNearService(array $profileData = [], array $serviceData = []): Service
    {
        $stateId = $this->user->profile->state->id;
        $cityId = $this->user->profile->city->id;
        $profileData = array_merge($profileData, [
            "state_id" => $stateId,
            "city_id" => $cityId,
        ]);
        return $this->makeService($profileData, $serviceData);
    }
}
