<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class AuthRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'phone' => 'requied|string',
            'OTP' => 'requied|string|6',
        ];

        // Rules cho phone
        $phoneRule = ['required', 'string'];
        if ($this->isMethod('post')) {
            $phoneRule[] = 'unique:accounts,phone';
        } else {
            $phoneRule[] = Rule::unique('accounts', 'phone')->ignore($this->user);
        }
        $rules['phone'] = $phoneRule;

        return $rules;
    }

    public function messages()
    {
        return [
            'phone.required' => 'Tên đăng nhập không được để trống',
            'phone.unique' => 'Tên đăng nhập đã tồn tại trong hệ thống',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => [
                [
                'field' => $validator->errors()->keys()[0],
                'message' => $validator->errors()->first()
                ]
            ]
        ], 422));
    }
}