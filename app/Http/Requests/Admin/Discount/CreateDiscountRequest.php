<?php

namespace App\Http\Requests\Admin\Discount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'title' => [
                'required',
                'string'
            ],
            'description' => [
                'required',
                'string'
            ],
            'is_percent' => [
                'nullable'
            ],
            'term_start' => [
                'required',
                'sometimes',
                'date_format:Y-m-d',
                'after:yesterday',
            ],
            'term_end' => [
                'required',
                'sometimes',
                'date_format:Y-m-d',
                'after_or_equal:term_start',
            ],
        ];

        if ($this->request->has('is_percent')) {
            $rules['val'] = [
                'required',
                'numeric',
                'min:1',
                'max:100'
            ];
        } else {
            $rules['val'] = [
                'required',
                'numeric',
                'min:1000',
                'max: 10000000'
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'Phải nhập trường này',
            'max'      => 'Phải nhập giá trị tối đa là :max',
            'min'      => 'Phải nhập giá trị tối thiểu là :min',
            'numeric'  => 'Phải nhập giá trị là số',
            'date_format' => 'Định dạng ngày chưa đúng (Y-m-d)',
            'after'     => 'Ngày bắt đầu tối thiểu từ ngày hôm nay',
            'after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu'
        ];
    }
}
