<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class AppFactory extends Factory
{
    protected function randomModel(string $model, array $for = []): ?Model
    {
        if (!class_exists($model)) {
            throw new ModelNotFoundException($model);
        }
        if ($model::count() > 0) {
            return $model::query()->inRandomOrder()->first();
        }
        $result = $model::factory();
        foreach ($for as $value) {
            $result = $result->for($value);
        }
        return $result->create();
    }
}
