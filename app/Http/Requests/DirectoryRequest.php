<?php

namespace App\Http\Requests;
use App\Rules\NotLowercase;
use App\Rules\NotUppercase;
use Illuminate\Validation\Rule;

class DirectoryRequest extends FormRequest
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
            'position' => ['required', new NotLowercase, 'max:100'],
            'email' => ['required','email', new NotUppercase, 'max:100'],
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
    }
}
