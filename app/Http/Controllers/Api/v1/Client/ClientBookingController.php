<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Enums\BookingStatus;
use App\Http\Controllers\AuthUserController;
use App\Http\Requests\v1\Client\ClientBookingRequest;
use App\Http\Resources\v1\BookingResource;
use App\Models\Booking;
use App\Models\ServiceItem;
use App\ModelServices\Booking\BookingService;
use Illuminate\Http\JsonResponse;

class ClientBookingController extends AuthUserController
{
    protected string $resource = BookingResource::class;

    public function __construct(
        private BookingService $bookingService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $bookings = $this->bookingService->getBookingsFor($this->authUser(), ["service", "item"]);
        return $this->ok($this->paginate($bookings));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientBookingRequest $request): JsonResponse
    {
        $data = $request->validated();
        $item = ServiceItem::find($data["item_id"]);
        $booking = $this->bookingService->make($this->authUser(), $item, $data);
        $booking->load("item");
        return $this->ok($booking);
    }

    public function cancel(Booking $booking): JsonResponse
    {
        $booking = $this->bookingService->cancel($this->authUser(), $booking);
        return $this->ok($booking);
    }

    public function complete(Booking $booking): JsonResponse
    {
        $booking = $this->bookingService->complete($booking);
        return $this->ok($booking);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): JsonResponse
    {
        $booking->load("service", "item");
        return $this->ok($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientBookingRequest $request, Booking $booking): JsonResponse
    {
        $booking = $this->bookingService->updateBooking($booking,$request->validated());
        return $this->ok($booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();
        return $this->deleted();
    }

}
