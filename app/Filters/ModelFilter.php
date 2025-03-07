<?php

namespace App\Filters;


use App\Filters\Trait\GlobalFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Filesystem\Filesystem;

abstract class ModelFilter
{
    protected array $globalFilters = ["search"];
    protected array $handlers = [];
    use GlobalFilters;

    public function apply(Builder $builder, array $data): Builder
    {
        $result = $this->applyDefaultHandlers($builder);
        return $this->applyHandlers($result, $data);
    }

    protected function applyDefaultHandlers(Builder $builder): Builder
    {
        foreach ($this->getDefaultHandlers() as $handler) {
            $builder = $handler->handle($builder, null);
        }
        return $builder;
    }

    protected function getDefaultHandlers(): array
    {
        $files = $this->getFileSystem()->files(__DIR__ . '/DefaultHandlers');
        $namespace = "App\\Filters\\DefaultHandlers\\";
        $result = [];
        foreach ($files as $file) {
            $name = str_replace(".php", '', $file->getFilename());
            $class = $namespace . $name;
            if (class_exists($class)) {
                $result[] = app()->make($class);
            }
        }
        return $result;
    }

    protected function applyHandlers(Builder $builder, array $data): Builder
    {
        foreach ($data as $key => $value) {
            $handler = $this->getHandler($key);
            if ($handler) {
                $builder = $handler->handle($builder, $value);
            }
        }
        return $builder;
    }

    protected function getHandler(string $key): ?IFilterHandler
    {
        $handlers = $this->getHandlers();
        if (in_array($key, $handlers) || array_key_exists($key, $handlers)) {
            if (method_exists($this, $key)) {
                return new CallbackFilter(fn($builder, $value) => $this->$key($builder, $value));
            }
            if (class_exists($key)) {
                return app()->make($key);
            }
        }
        return null;
    }

    private function getHandlers(): array
    {
        return array_merge($this->handlers, $this->getGlobalFilters());
    }

    protected function getGlobalFilters(): array
    {
        return $this->globalFilters;
    }

    protected function getFileSystem(): Filesystem
    {
        return app()->make(Filesystem::class);
    }
}
