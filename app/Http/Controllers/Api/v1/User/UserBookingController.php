<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Resources\v1\BookingResource;
use App\Models\Booking;
use App\Models\ServiceItem;
use App\ModelServices\Booking\BookingService;
use Illuminate\Http\JsonResponse;

class UserBookingController extends AuthUserController
{
    protected string $resource = BookingResource::class;
    protected ?string $ownerRelation = "service";

    public function __construct(
        public BookingService $bookingService
    ) {}

    public function index(): JsonResponse
    {
        $bookings = $this->bookingService->getServicesBookings($this->authUser(), ["service", "item"]);
        return $this->ok($this->paginate($bookings));
    }
    public function itemBookings(ServiceItem $item): JsonResponse
    {
        $bookings = $this->bookingService->availableBookingsFor($item, ["item", "service"]);
        return $this->ok($this->paginate($bookings));
    }
    public function show(Booking $booking): JsonResponse
    {
        $booking->load(["user", "service", "item", "reviews"]);
        return $this->ok($booking);
    }

    public function cancel(Booking $booking): JsonResponse
    {
        $booking = $this->bookingService->cancel($this->authUser(), $booking);
        return $this->ok($booking);
    }

    public function confirm(Booking $booking): JsonResponse
    {
        $booking = $this->bookingService->confirm($booking);
        return $this->ok($booking);
    }
}
