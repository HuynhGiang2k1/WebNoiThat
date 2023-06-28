<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'price' => [
                'required',
                'numeric',
            ],
            'quantity' => [
                'required',
                'numeric',
            ],
            'size' => [
                'required',
                'string'
            ],
            'description' => [
                'nullable',
                'string'
            ],
        ];

        if (!$this->request->has('categories') && !$this->request->has('subcategories')) {
            $rules['subcategories'] = [
                'required',
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'required'  => 'Bạn phải nhập trường này',
            'numeric'   => 'Phải nhập dữ liệu là số',
            'max'      => "Tên tối đa :max ký tự",
        ];
    }
}
