<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AlphaNumDashUnder implements ValidationRule
{
    private $message = ':attributeはアルファベットと数字とダッシュ(-)及び下線(_)がご利用できます。';

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if (is_string($value) === false) {
            $fail($this->message);
        }

        if (preg_match('/^[A-Za-z\d_-]+$/u', $value) === 1) {

        } else {
            $fail($this->message);
        }
    }
}
