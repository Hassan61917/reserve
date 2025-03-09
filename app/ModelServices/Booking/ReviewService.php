<?php

namespace App\ModelServices\Booking;

use App\Enums\BookingStatus;
use App\Exceptions\ModelException;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Service;
use App\Models\ServiceItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReviewService
{
    public function getAllReviews(array $relations = []): Builder
    {
        return Review::query()->with($relations);
    }

    public function getMyReviews(User $user, array $relations = []): HasMany
    {
        return $user->reviews()->with($relations);
    }

    public function getServicesReviews(User $user, array $relations = []): Builder
    {
        return Review::query()
            ->join("bookings", "bookings.id", "=", "reviews.booking_id")
            ->join("services", "services.id", "=", "bookings.service_id")
            ->where("services.user_id", $user->id)
            ->with($relations);
    }

    public function reviewsForService(Service $service, array $relations = []): Builder
    {
        return Review::query()
            ->join("bookings", "bookings.id", "=", "reviews.booking_id")
            ->where("bookings.service_id", $service->id)
            ->with($relations);
    }

    public function reviewsForItem(ServiceItem $item, array $relations = []): Builder
    {
        return Review::query()
            ->join("bookings", "bookings.id", "=", "reviews.booking_id")
            ->where("bookings.item_id", $item->id)
            ->with($relations);
    }

    public function make(User $user, array $data)
    {
        $booking = Booking::find($data["booking_id"]);
        if (!$user->is($booking->user)) {
            throw new ModelException("You only can review for your own bookings.");
        }
        if (!$booking->status != BookingStatus::Completed->value) {
            throw new ModelException("you must complete booking before making review");
        }
        return $user->reviews()->create($data);
    }


}
