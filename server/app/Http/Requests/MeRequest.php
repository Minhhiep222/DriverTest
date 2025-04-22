<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class MeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('put')) {
            $user = auth()->user();
            // Debug để xem ID
            // dd($user->id);

            $userId = $user->id; // Lưu lại ID để đảm bảo tính nhất quán

            $rules = [
                'image' => 'nullable',
                'fullname' => 'nullable|string|max:255',
                'shortname' => 'nullable|string|max:255',
                'email' => [
                    'nullable',
                    'string',
                    function ($attribute, $value, $fail) use ($userId) {
                        $exists = DB::table('users')
                            ->where('email', $value)
                            ->where('id', '!=', $userId)
                            ->exists();

                        if ($exists) {
                            $fail('Email đã tồn tại trong hệ thống.');
                        }
                    }
                ],
                'MST' => ['nullable', 'string', Rule::unique('users', 'MST')->ignore($userId)],
                'address' => 'nullable|string',
                'website' => 'nullable|string',
                'description' => 'nullable|string',
                'phone' => [
                    'required',
                    'string',
                    Rule::unique('users', 'phone')->ignore($userId),
                    // Xác định rõ cột khóa chính của bảng accounts
                    Rule::unique('accounts', 'phone')->ignore($userId, 'user_id') // Giả sử accounts có cột user_id liên kết với users
                ],
                'role' => 'nullable|string|in:Admin,user',
                'status' => 'nullable|string|in:Active,Inactive',
            ];
        }

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
