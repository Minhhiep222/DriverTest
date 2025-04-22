<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class DriverTestRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'img' => 'nullable|array|min:1',
            'img.*' => 'nullable',
            'color' => 'required|string|max:255',
            'showroom' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_time' => 'nullable', // Ngày bắt đầu >= ngày hiện tại
            'end_time' => 'required|date|after_or_equal:today', // Ngày kết thúc > ngày bắt đầu
            'description' => 'required|string',
            'status' => 'required|string|in:Active,Inactive',
        ];
    }
    public function messages()
    {
        return [
            'img.required' => 'Vui lòng thêm ảnh',
            'name.required' => 'Tên không được để trống',
            'color.required' => 'Màu không được để trống',
            'contact.required' => 'Thông tin liên hệ không được để trống',
            'showroom.required' => 'Tên hãng không được để trống',
            'vehicle_type.required' => 'Dòng xe không được để trống',
            'location.required' => 'Địa chỉ không được để trống',
            'start_time.required' => 'Vui lòng chọn thời gian bắt đầu',
            'start_time.after_or_equal' => 'Thời gian bắt đầu phải từ ngày hiện tại trở đi',
            'end_time.required' => 'Vui lòng chọn thời gian kết thúc',
            'end_time.after' => 'Thời gian kết thúc phải lớn hơn ngày hiện tại',
            'status.required' => 'Trạng thái không được để trống',
            'description.required' => 'Mô tả không được để trống',
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
