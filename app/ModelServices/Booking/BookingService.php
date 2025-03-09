<?php

namespace App\ModelServices\Booking;

use App\Enums\BookingStatus;
use App\Events\BookingStatusUpdated;
use App\Events\ItemWasBooked;
use App\Exceptions\ModelException;
use App\Handlers\Booking\BookingHandler;
use App\Models\Booking;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\User;
use App\ModelServices\Financial\OrderService;
use App\ModelServices\Financial\WalletService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookingService
{
    public function __construct(
        private BookingHandler $bookingHandler,
        private WalletService  $walletService,
        private OrderService   $orderService,
    )
    {
    }

    public function getAllBookings(array $relations = []): Builder
    {
        return Booking::query()->available()->with($relations);
    }

    public function getBookingsFor(User $user, array $relations = []): HasMany
    {
        return $user->bookings()->with($relations);
    }

    public function make(User $user, ServiceItem $item, array $data): Booking
    {
        $this->bookingHandler->handle($item, $data);
        $booking = $user->bookings()->create([
            "service_id" => $item->service->id,
            "status" => BookingStatus::Draft->value,
            ...$data
        ]);
        ItemWasBooked::dispatch($booking);
        return $booking;
    }

    public function canBook(array $data): bool
    {
        $item_id = $data["item_id"];
        $date = $data["date"];
        $hour = $data["hour"];

        return !Booking::query()
            ->where("item_id", $item_id)
            ->where("date", $date)
            ->where("hour", $hour)
            ->exists();
    }

    public function getServicesBookings(User $user, array $relations = []): Builder
    {
        $serviceIds = $user->services()->pluck("id")->toArray();
        return Booking::whereIn("service_id", $serviceIds)->available()->with($relations);
    }

    public function availableBookingsFor(Service|ServiceItem $service, array $relations = []): HasMany
    {
        return $service->bookings()->available()->with($relations);
    }

    public function updateBooking(Booking $booking, array $data = []): Booking
    {
        if ($booking->status == BookingStatus::Completed->value) {
            throw new ModelException("completed bookings can not be updated");
        }
        if ($booking->hour != $data["hour"] || $booking->date != $data["date"]) {
            if (Booking::bookedAt($data["hour"], $data["date"])->exists()) {
                throw new ModelException("item is already booked");
            }
            $booking->update([...$data]);
        }
        if ($booking->status == BookingStatus::Confirmed->value) {
            $this->updateStatus($booking, BookingStatus::Paid);
        }
        return $booking;
    }

    public function order(Booking $booking): Booking
    {
        $this->updateStatus($booking, BookingStatus::Paid);
        return $booking;
    }

    public function confirm(Booking $booking): Booking
    {
        $this->updateStatus($booking, BookingStatus::Confirmed);
        return $booking;
    }

    public function cancel(User $user, Booking $booking): Booking
    {
        $amount = $booking->price;
        if ($booking->status == BookingStatus::Confirmed->value) {
            $amount = $this->getCancelAmount($user, $booking);
        }
        $this->orderService->cancel($booking->order, $amount);
        $this->updateStatus($booking, BookingStatus::Cancelled);
        return $booking;
    }

    public function complete(Booking $booking): Booking
    {
        $amount = $this->calculateAmount($booking);
        $this->walletService->deposit($booking->service->user, $amount);
        $this->orderService->complete($booking->order);
        $this->updateStatus($booking, BookingStatus::Completed);
        return $booking;
    }

    public function updateStatus(Booking $booking, BookingStatus $status): Booking
    {
        $booking->update(["status" => $status->value]);
        BookingStatusUpdated::dispatch($booking);
        return $booking;
    }

    private function getCancelAmount(User $user, Booking $booking): int
    {
        $amount = $booking->order->getAmount();
        if ($user->is($booking->user)) {
            $this->walletService->deposit($booking->service->user, $amount + ($amount * 0.1));
            $amount *= 0.9;
        }
        if ($user->is($booking->service->user)) {
            $this->walletService->withdraw($booking->service->user, $amount * 0.1);
            $amount *= 1.1;
        }
        return $amount;
    }

    private function calculateAmount(Booking $booking): int
    {
        $order = $booking->order;
        $discountCode = $order->discount_code;
        if ($discountCode) {
            $discount = $this->orderService->findDiscount($order->discount_code);
            if ($discount->user->is($booking->service->user)) {
                return $order->discount_price;
            }
        }
        return $order->total_price;
    }
}
