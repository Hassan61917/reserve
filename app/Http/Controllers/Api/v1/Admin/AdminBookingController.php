<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Client\ClientBookingRequest;
use App\Http\Resources\v1\BookingResource;
use App\Models\Booking;
use App\ModelServices\Booking\BookingService;
use Illuminate\Http\JsonResponse;

class AdminBookingController extends Controller
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
        $bookings = $this->bookingService->getAllBookings(["service", "item"]);
        return $this->ok($this->paginate($bookings));
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking): JsonResponse
    {
        $booking->load(["user", "service", "item", "reviews"]);
        return $this->ok($booking);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientBookingRequest $request, Booking $booking): JsonResponse
    {
        $booking = $this->bookingService->updateBooking($booking, $request->validated());
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
