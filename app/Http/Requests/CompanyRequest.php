<?php

namespace App\Http\Requests;

use App\Rules\NotLowercase;
use App\Rules\NotUppercase;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', new NotUppercase, new NotLowercase, 'max:100'],
            'type' => ['required'],
            'cover' => 'required_at_create|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
