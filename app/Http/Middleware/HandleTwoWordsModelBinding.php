<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Symfony\Component\HttpFoundation\Response;

class HandleTwoWordsModelBinding
{
    public function handle(Request $request, Closure $next): Response
    {
        $this->handleParameters($request->route());
        return $next($request);
    }

    private function handleParameters(Route $route): void
    {
        $parameters = $route->parameters();
        foreach ($parameters as $key => $value) {
            if (str_contains($key, '_')) {
                $model = $this->getModel(str($key)->camel()->toString());
                $value = $model->resolveRouteBinding($value);
            }
            $route->setParameter($key, $value);
        }
    }

    public function getModel(string $key): Model
    {
        return app("App\\Models\\{$key}");
    }
}
