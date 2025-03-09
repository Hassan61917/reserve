<?php

namespace Tests\Feature\User;

use App\Enums\BookingStatus;
use App\Enums\ServiceStatus;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceDayoff;
use App\Models\ServiceItem;
use App\Models\ServiceProfile;
use App\Models\User;
use Carbon\Carbon;
use Tests\UserTest;

class UserBookingTest extends UserTest
{
    protected string $role = "client";
    public function test_store_user_can_not_book_un_completed_services()
    {
        $service = Service::factory()->for($this->user)->create();
        $data = $this->createData($service);
        $res = $this->postJson(route("v1.client.bookings.store"), $data);
        $res->assertStatus(422);
    }

    public function test_store_user_can_not_book_his_owns_services()
    {
        $data = $this->createData();
        $res = $this->postJson(route("v1.user.bookings.store"), $data);
        $res->assertStatus(423);
    }

    public function test_store_user_can_not_book_in_dayOff_days()
    {
        $in_week = 7;
        $in_month = 12;
        $service = $this->createService();
        ServiceDayoff::factory()->for($service)->create([
            "in_week" => $in_week,
            "in_month" => $in_month,
        ]);
        $date = Carbon::make("2/7/2025"); // it is Friday
        $data = $this->createData($service, ["date" => $date]);
        $res = $this->postJson(route("v1.user.bookings.store"), $data);
        $res->assertStatus(423);
        $date = Carbon::make("2/{$in_month}/2025"); // it is 12th of February
        $data = $this->createData($service, ["date" => $date]);
        $res = $this->postJson(route("v1.user.bookings.store"), $data);
        $res->assertStatus(423);
    }

    public function test_store_user_can_not_book_when_service_is_closed()
    {
        $date = now()->hour(7);
        $data = $this->createData(null, ["date" => $date]);
        $res = $this->postJson(route("v1.user.bookings.store"), $data);
        $res->assertStatus(423);
        $date = now()->hour(16);
        $data = $this->createData(null, ["date" => $date]);
        $res = $this->postJson(route("v1.user.bookings.store"), $data);
        $res->assertStatus(423);
    }

    public function test_store_user_can_book_a_service_item()
    {
        $data = $this->createData();
        $this->withoutExceptionHandling();
        $this->postJson(route("v1.user.bookings.store"), $data);
        $this->assertDatabaseCount("bookings", 1);
    }

    public function test_store_user_can_not_book_when_someone_else_booked()
    {
        $data = $this->createData();
        Booking::factory()->create($data);
        $res = $this->postJson(route("v1.user.bookings.store"), $data);
        $res->assertStatus(423);
    }

    private function createData(?Service $service = null, array $data = []): array
    {
        if (!$service) {
            $service = $this->createService();
        }
        $item = ServiceItem::factory()->for($service)->create();
        return Booking::factory()
            ->for($this->user)
            ->for($service)
            ->for($item, "item")
            ->raw($data);
    }

    public function createService(): Service
    {
        $service = Service::factory()->create(["status" => ServiceStatus::Complete->value]);
        ServiceProfile::factory()->for($service)->create(["start_hour" => 8, "end_hour" => 16]);
        return $service;
    }
}
