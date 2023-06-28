<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
        $rules =  [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:products'
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
            'cover' => [
                'required'
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
            'required'  => 'Trường này không được để trống',
            'numeric'   => 'Phải nhập dữ liệu là số',
            'unique'    => 'Tên sản phẩm đã được sử dụng',
            'max'      => "Tên tối đa :max ký tự",
        ];
    }
}
