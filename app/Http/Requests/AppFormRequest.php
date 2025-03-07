<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppFormRequest extends FormRequest
{
    protected array $unset = [];
    protected ?string $withSlug = null;

    public function authorize(): bool
    {
        return true;
    }

    public function validated($key = null, $default = null)
    {
        $result = parent::validated($key, $default);
        if ($this->withSlug) {
            $result["slug"] = str($result[$this->withSlug])->slug()->toString();
        }
        return $result;
    }

    protected function validationRules(): array
    {
        $rules = parent::validationRules();
        $this->unsetModels($rules);
        return $rules;
    }

    public function unset(array $array): static
    {
        $this->unset = $array;
        return $this;
    }

    protected function unsetModels(array &$data): void
    {
        if ($this->method() == "POST") {
            return;
        }
        foreach ($this->unset as $key) {
            if (array_key_exists($key, $data)) {
                unset($data[$key]);
            }
        }
    }
}
