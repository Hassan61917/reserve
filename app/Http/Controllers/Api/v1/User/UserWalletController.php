<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\AuthUserController;
use App\Http\Resources\v1\WalletResource;
use App\Models\Wallet;
use App\ModelServices\Financial\WalletService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserWalletController extends AuthUserController
{
    protected string $resource = WalletResource::class;

    public function __construct(
        private WalletService $walletService,
    )
    {
    }

    public function index(): JsonResponse
    {
        $user = $this->authUser(["wallet"]);
        if (!$user->wallet) {
            $user->wallet()->create();
        }
        $wallet = $user->wallet()->with("user")->first();
        return $this->ok($wallet);
    }

    public function setPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            "password" => "required|string|min:6",
        ]);
        $wallet = $this->walletService->updatePassword($this->authUser(), $data["password"]);
        return $this->ok($wallet);
    }
}
