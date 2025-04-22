<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class BookDriverRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'time_drive' => 'required',
            'date_drive' => 'required|date',
            'driver_test_id' => 'required|integer',
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'note' => 'nullable|string',
            'status' => 'nullable|string|in:Active,Inactive',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'driver_test_id.required' => 'Driver id không được để trống',
            'fullname.required' => 'Tên khách không được để trống',
            'phone.required' => 'Số điện thoại không được để trống',
            'time_drive.required' => 'Vui lòng chọn thời gian lái',
            'date_drive.required' => 'Vui lòng chọn thời gian lái',
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
