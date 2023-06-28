<?php

namespace App\Http\Requests\Front\User;

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
            'name' => 'required',
            'password' => 'nullable|min:8',
            'tel' => [
                'nullable',
                'string',
                New PhoneVN,
            ],
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute Không Để Trống',
            'numeric' => ':attribute Không Hợp Lệ',
            'digits_between' => ':attribute phải có 11 ký tự',
            'image' => ':attribute không đúng định dạng',
            'mimes' => ':attribute không đúng định dạng',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên',
            'password' => 'Mật Khẩu',
            'tel' => 'Số Điện Thoại',
            'address' => 'Địa Chỉ',
            'avatar' => 'Avatar'
        ];
    }
}
