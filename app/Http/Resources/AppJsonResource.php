<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class AppJsonResource extends JsonResource
{
    protected array $resources = [];
    public function resolve($request = null)
    {
        $data = parent::resolve($request);
        foreach ($this->resources as $resource) {
            $instance = $resource::make($this->resource);
            $data = array_merge($data, $instance->resolve($request));
        }
        return $data;
    }
    protected function mergeRelation(string $resource, string $relation, array $relations = []): MissingValue|JsonResource
    {
        $value = $this->loadRelation($relation, $relations);
        if (!$value) {
            return new MissingValue();
        }
        $value = $this->getResource($resource, $value);
        return $this->mergeWhenLoaded($relation, $value);
    }

    protected function mergeRelations(string $resource, string $relation, array $relations = [], int $count = 10): MissingValue|JsonResource
    {
        $value = $this->getResource($resource, $this->loadRelations($relation, $relations, $count));
        return $this->mergeWhenLoaded($relation, $value);
    }

    protected function mergeCount(string $relation): MissingValue|int
    {
        if (!str_ends_with($relation, 'count')) {
            $relation .= '_count';
        }
        $value = $this->$relation;
        return is_numeric($value) ? (int) $value : new MissingValue();
    }

    protected function mergeWhenLoaded(string $relation, mixed $value): mixed
    {
        return $this->whenLoaded($relation, fn() => $value);
    }
    protected function getResource(string $resource, Model|LengthAwarePaginator $value)
    {
        if ($value instanceof LengthAwarePaginator) {
            return $resource::collection($value);
        }
        return $resource::make($value);
    }

    protected function loadRelation(string $relation, array $relations = []): ?Model
    {
        return $this->getRelation($relation, $relations)->first();
    }

    protected function loadRelations(string $relation, array $relations = [], int $count = 10): LengthAwarePaginator
    {
        return $this->getRelation($relation, $relations)->paginate($count);
    }

    protected function getRelation(string $relation, array $relations = []): Relation
    {
        return $this->resource->$relation()->with($relations);
    }
}
