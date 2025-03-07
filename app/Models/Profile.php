<?php

namespace App\Models;

use App\Models\Trait\Relations\ProfileRelations;

class Profile extends AppModel
{
    use ProfileRelations;

    protected $fillable = [
        "state_id",
        "city_id",
        "name",
        "avatar",
        "phone"
    ];
}
