<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'image' => 'nullable',
            'fullname' => 'nullable|string|max:255',
            'shortname' => 'nullable|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('accounts')->ignore($this->user)],
            'MST' => 'nullable|string',
            'address' => 'nullable|string',
            'website' => 'nullable|string',
            'description' => 'nullable|string',
            'phone' => 'required|string',
            'role' => 'nullable|string|in:Admin,user',
            'status' => 'nullable|string|in:Active,Inactive',
        ];

        // Rules cho phone
        $phoneRule = ['required', 'string'];

        if ($this->isMethod('post')) {
            $phoneRule[] = 'unique:users,phone';
            $phoneRule[] = 'unique:accounts,phone';
        } else {
            $user = User::where('id', $this->user)->firstOr();
            $phoneRule[] = Rule::unique('users', 'phone')->ignore($this->user);
            $phoneRule[] = Rule::unique('accounts', 'phone')->ignore($user->account_id);
        }
        $rules['phone'] = $phoneRule;

        // Rules cho email
        $emailRule = ['nullable', 'string'];

        if ($this->isMethod('post')) {
            $emailRule[] = 'unique:users,email';
        } else {
            $emailRule[] = Rule::unique('users', 'email')->ignore($this->user);
        }
        $rules['email'] = $emailRule;

        // Rules cho email
        $MSTRule = ['nullable', 'string'];

        if ($this->isMethod('post')) {
            $MSTRule[] = 'unique:users,MST';
        } else {
            $MSTRule[] = Rule::unique('users', 'MST')->ignore($this->user);
        }

        $rules['MST'] = $MSTRule;

        return $rules;
    }

    public function messages()
    {
        return [
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.unique' => 'Số điện thoại đã tồn tại trong hệ thống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'MST.unique' => 'MST đã tồn tại trong hệ thống',
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
