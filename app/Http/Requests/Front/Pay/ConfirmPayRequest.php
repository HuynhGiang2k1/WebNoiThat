<?php

namespace App\Http\Requests\Front\Pay;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPayRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
            ],
            'streetAddress' => [
                'required',
                'string',
            ],
            'townCity' => [
                'required',
                'string',
            ],
            'phone' => [
                'required',
            ],
            'email' => [
                'required',
                'string',
                'email',
            ],
            'orderNotes' => [
                'nullable',
                'string',
            ],
            'cartIds' => [
                'required'
            ],
            'payOptions' => [
                'required'
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường này không được để trống',
            'email'    => 'Email không đúng định dạng',
        ];
    }
}
