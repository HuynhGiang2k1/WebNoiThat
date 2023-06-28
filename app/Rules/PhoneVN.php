<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class PhoneVN implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $pattern = '/^(((\+|)84)|((\+|)84 )|0)(3|5|7|8|9)+([0-9]{8})$\b/';
        if(!preg_match($pattern, $value, $matches)) {
            $fail('Số điện thoại không đúng định dạng');
        }
    }
}
