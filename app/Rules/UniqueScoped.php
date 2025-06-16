<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\ValidationRule;

class UniqueScoped implements ValidationRule
{
    protected string $model;
    protected string $column;
    protected mixed $value;
    protected ?int $ignoreId;

    public function __construct(string $model, string $column, mixed $value, ?int $ignoreId = null)
    {
        $this->model = $model;
        $this->column = $column;
        $this->value = $value;
        $this->ignoreId = $ignoreId;
    }

    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        $query = app($this->model)::where($this->column, $this->value);

        if ($this->ignoreId) {
            $query->where('id', '!=', $this->ignoreId);
        }

        if ($query->exists()) {
            $fail('The :attribute has already been taken.');
        }
    }
}
