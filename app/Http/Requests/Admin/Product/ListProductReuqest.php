<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ListProductReuqest extends FormRequest
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
        return [
            'id' => [
                'nullable',
                'numeric',
            ],
            'name' => [
                'nullable',
                'string',
                'max:80'
            ],
        ];
    }

    public function messages()
    {
        return [
            'numeric' => "Trường này chỉ được nhập số",
            'max'     => "Chỉ được nhập tối đa :max ký tự"
        ];
    }
}
