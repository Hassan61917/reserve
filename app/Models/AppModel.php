<?php

namespace App\Models;

use App\Models\Trait\Scopes\AppModelScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class AppModel extends Model
{
    use HasFactory, AppModelScopes;
    public function getRouteKeyName(): string
    {
        if (in_array('slug', $this->fillable)) {
            return "slug";
        }
        return parent::getRouteKeyName();
    }
}
