<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageUploadRequest extends FormRequest
{
    public function rules()
    {
        return [
            'image' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'image.file' => 'File upload không hợp lệ.',
            'image.mimes' => 'File phải có phần mở rộng là: jpeg, jpg, png, gif.',
            'image.max' => 'File không được lớn hơn 2MB.',
        ];
    }

    public function authorize()
    {
        return true;
    }
}