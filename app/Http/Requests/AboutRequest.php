<?php

namespace App\Http\Requests;

use App\Rules\NotLowercase;
use App\Rules\NotUppercase;
use Illuminate\Validation\Rule;

class AboutRequest extends FormRequest
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
            'type' => ['required'],
            'description' => ['required', new NotUppercase, new NotLowercase, 'max:500'],
        ];
    }
}
