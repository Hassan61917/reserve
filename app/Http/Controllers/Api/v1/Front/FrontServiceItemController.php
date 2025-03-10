<?php

namespace App\Http\Controllers\Api\v1\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\ServiceItemResource;
use App\Models\ServiceItem;
use App\ModelServices\Service\FrontServiceItemHandler;
use App\ModelServices\Social\VisitService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrontServiceItemController extends Controller
{
    protected string $resource = ServiceItemResource::class;

    public function __construct(
        private FrontServiceItemHandler $itemHandler,
        private VisitService            $visitService
    )
    {
    }

    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $items = $this->itemHandler->getAvailableItems($page, now(),$this->authUser());
        return $this->ok(null, ServiceItemResource::collection($items));
    }

    public function show(ServiceItem $item): JsonResponse
    {
        $item->load("reviews", "questions")
            ->loadCount("visits", "likes", "dislikes", "wishlist", "bookings");
        $this->visitService->visit($item, $this->authUser(), request()->ip());
        return $this->ok($item);
    }
}
