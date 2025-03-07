<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

trait CheckOwner
{
    protected ?string $ownerRelation = "";
    protected ?string $ownerName = null;
    protected function isOwner(?Model $model): void
    {
        if (!$model || $this->ownerRelation === null) {
            return;
        }
        $model = $this->getOwnerModel($model);
        $name = $this->ownerName != null ? $this->ownerName : $model->user;
        Gate::allowIf($this->authUser()->is($name))->authorize();
    }

    protected function getOwnerModel(Model $model): Model
    {
        $relations = array_filter(explode(".", $this->ownerRelation));
        $result = $model;
        foreach ($relations as $relation) {
            $result = $result->$relation;
        }
        return $result;
    }
}
