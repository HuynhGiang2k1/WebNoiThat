<?php

namespace App\Rules;

use App\Repository\CartRepository;
use Illuminate\Contracts\Validation\InvokableRule;

class ArrayHF implements InvokableRule
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
        if (!is_array(json_decode($value)) || empty(json_decode($value))) {
            $fail('Bạn chưa chọn sản phẩm');
        } else {
            $message= '';
            $cartItems = resolve(CartRepository::class)->getItemByIds(json_decode($value))->get();
            foreach ($cartItems as $item) {
                if ($item->quantity > 10) {
                    $message .= "<p>Sản phẩm {$item->product->name} chỉ được mua tối đa 10 sản phẩm</p>";
                }else if ($item->quantity > $item->product->quantity) {
                    $message .= "<p>Sản phẩm {$item->product->name} chỉ còn lại {$item->product->quantity}</p>";
                }
            }
            if ($message) {
                $fail($message);
            }
        }
    }
}
