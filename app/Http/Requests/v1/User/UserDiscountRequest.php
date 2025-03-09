<?php

namespace App\Http\Requests\v1\User;

use App\Http\Requests\v1\Admin\AdminDiscountRequest;

class UserDiscountRequest extends AdminDiscountRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        if (array_key_exists('category_id', $rules)) {
            unset($rules['category_id']);
        }
        $rules["service_id"] = "nullable|exists:services,id";
        $rules["item_id"] = "nullable|exists:service_items,id";
        return $rules;
    }
}
