<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Metric implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return is_numeric($value) ||
                stripos($value, 'K') == strlen($value) - 1 && is_numeric(substr($value, 0, strlen($value) - 1)) ||
            stripos($value, 'M') == strlen($value) - 1 && is_numeric(substr($value, 0, strlen($value) - 1));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.metric');
    }
}
