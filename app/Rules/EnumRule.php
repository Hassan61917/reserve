<?php

namespace App\Rules;

use App\Utils\EnumHelper;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnumRule implements ValidationRule
{
    public function __construct(
        private string $enum
    )
    {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $value = strtolower($value);
        $constants = array_map(fn($item) => strtolower($item),EnumHelper::toArray($this->enum));
        if (!in_array($value, $constants)) {
            $fail("{$value} is not a valid value for field {$attribute}");
        }
    }

}
