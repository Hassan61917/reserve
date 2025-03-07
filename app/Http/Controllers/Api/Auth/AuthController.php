<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Auth\LoginRequest;
use App\Http\Requests\v1\Auth\RegisterRequest;
use App\Models\User;
use App\ModelServices\User\AuthService;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authService->register($data);
        $token = $this->getToken($user);
        return $this->success(200, [
            "token" => $token
        ]);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->authService->login($data);
        $token = $this->getToken($user);
        return $this->success(200, [
            "token" => $token
        ]);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return $this->success(200, [
            "message" => "Logged out"
        ]);
    }

    private function getToken(User $user): string
    {
        return $user->createToken(env('APP_NAME'))->plainTextToken;
    }
}
