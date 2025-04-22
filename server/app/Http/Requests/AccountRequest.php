<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class AccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'fullname' => 'nullable|string|max:255',
            'shortname' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($this->user)],
            'MST' => 'nullable|string',
            'address' => 'nullable|string',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'phone' => 'requied|string',
            'role' => 'required|string|in:admin,user',
            'status' => 'required|string|in:Active, Inactive',
        ];

        // Rules cho phone
        $phoneRule = ['required', 'string'];
        if ($this->isMethod('post')) {
            $phoneRule[] = 'unique:users,phone';
        } else {
            $phoneRule[] = Rule::unique('users', 'phone')->ignore($this->user);
        }
        $rules['phone'] = $phoneRule;

        // Rules cho email
        $emailRule = ['nullable', 'email'];
        if ($this->isMethod('post')) {
            $emailRule[] = 'unique:users,email';
        } else {
            $emailRule[] = Rule::unique('users', 'email')->ignore($this->user);
        }
        $rules['email'] = $emailRule;

        return $rules;
    }

    public function messages()
    {
        return [
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
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