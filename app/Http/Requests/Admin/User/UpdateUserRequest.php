<?php

namespace App\Http\Requests\Admin\User;

use App\Rules\PhoneVN;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
                'max:80'
            ],
            'password' => 'nullable|min:8',
            'email' => [
                'required',
                'email:filter',
                'unique:users,email,'.$this->route('id').',id'
            ],
            'tel' => [
                'nullable',
                'string',
                new PhoneVN
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => "Phải nhập trường này",
            'unique'   => "Email đã được sử dụng",
            'max'      => "Tên tối đa :max ký tự",
            'email'     => "Email chưa đúng định dạng"
        ];
    }
}
