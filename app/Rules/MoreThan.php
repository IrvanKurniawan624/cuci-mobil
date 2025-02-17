<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MoreThan implements Rule
{
    protected $otherField;

    public function __construct($otherField)
    {
        $this->otherField = $otherField;
    }

    public function passes($attribute, $value)
    {
        $otherValue = request()->input($this->otherField);

        return $value >= $otherValue;
    }

    public function message()
    {
        return ':attribute harus lebih besar dari ' . $this->otherField;
    }
}
