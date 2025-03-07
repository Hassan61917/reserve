<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait WithResponses
{
    protected string $resource;

    protected function deleted(): JsonResponse
    {
        return $this->success(204, []);
    }

    protected function ok(Model|Paginator|null $value, ?JsonResource $resource = null): JsonResponse
    {
        $resource = $resource ?: $this->getResource($value);
        return $this->success(200, $resource);
    }

    protected function paginate(Relation|Builder $builder, bool $withFilters = true): Paginator
    {
        if ($withFilters) {
            $builder = $builder->withFilters();
        }
        return $builder->paginate(env("PAGE_SIZE", 10));
    }
    protected function getResource(Model|Paginator $value): JsonResource
    {
        if ($value instanceof Model) {
            return $this->resource::make($value);
        }
        return $this->resource::collection($value);
    }

    protected function success(int $status, JsonResource|array $resource): JsonResponse
    {
        return $this->response($status, $resource);
    }

    protected function message(string $message): JsonResponse
    {
        return $this->response(200, [
            'message' => $message
        ]);
    }
    protected function error(int $status, string $message): JsonResponse
    {
        return $this->response($status, [
            'message' => $message
        ]);
    }
    protected function response(int $status, JsonResource|array $data): JsonResponse
    {
        return response()->json($data, $status);
    }
}
