<?php

namespace App\Http\Controllers\Api\v1\Client;

use App\Http\Controllers\AuthUserController;
use App\Http\Resources\v1\WishlistResource;
use App\Models\ServiceItem;
use App\Models\Wishlist;
use App\ModelServices\Financial\WishlistService;
use Illuminate\Http\JsonResponse;

class ClientWishlistController extends AuthUserController
{
    protected string $resource = WishlistResource::class;

    public function __construct(
        public WishlistService $wishlistService
    )
    {
    }

    public function index(): JsonResponse
    {
        $wishList = $this->wishlistService->getAllFor($this->authUser(), ["item"]);
        return $this->ok($this->paginate($wishList));
    }

    public function store(ServiceItem $item): JsonResponse
    {
        $wish = $this->wishlistService->make($this->authUser(), $item);
        return $this->ok($wish);
    }

    public function show(Wishlist $wish): JsonResponse
    {
        $wish->load("item");
        return $this->ok($wish);
    }

    public function destroy(Wishlist $wish): JsonResponse
    {
        $wish->delete();
        return $this->deleted();
    }
}
