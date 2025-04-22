<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable',
            'area' => 'nullable|string',
            'image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
            'hobbit' => 'nullable|string',
            'income' => 'nullable|integer',
            'members' => 'nullable|integer',
            'age' => 'nullable|integer',
            'owned' => 'nullable|string|in:yes,no',
            'sex' => 'nullable|string|in:male,female',
            'status' => 'nullable|string|in:Active,Inactive',
            'type' => 'nullable|string|in:normal,vip',
        ];

        return $rules;
    }
}
