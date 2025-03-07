<?php

namespace App\Http\Middleware;

use App\ModelServices\User\BanService;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BanMiddleware
{
    public function __construct(
        private BanService $banService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($this->banService->isBanned($user)) {
            throw new AuthorizationException("banned users can not do this action");
        }
        return $next($request);
    }
}
