<?php

namespace App\Http\Requests;

use App\Rules\NotLowercase;
use App\Rules\NotUppercase;
use Illuminate\Validation\Rule;

class BannerRequest extends FormRequest
{
   
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', new NotUppercase, new NotLowercase, 'max:100'],
            'description' => ['max:4000'],
            'link' => ['required', 'max:60'],
            'cover' => 'required_at_create|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
