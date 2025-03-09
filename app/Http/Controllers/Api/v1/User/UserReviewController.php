<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Resources\v1\ReviewResource;
use App\Models\Review;
use App\ModelServices\Booking\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserReviewController extends AuthUserController
{
    protected string $resource = ReviewResource::class;
    protected ?string $ownerRelation = "booking.service";

    public function __construct(
        public ReviewService $reviewService
    )
    {
    }

    public function index(): JsonResponse
    {
        $reviews = $this->reviewService->getServicesReviews($this->authUser());
        return $this->ok($this->paginate($reviews));
    }

    public function show(Review $review): JsonResponse
    {
        $review->load('user', "bookings.service,item");
        return $this->ok($review);
    }

    public function reply(Review $review, Request $request): JsonResponse
    {
        $data = $request->validate([
            "reply" => "required"
        ]);
        $review->update($data);
        return $this->ok($review);
    }
}
