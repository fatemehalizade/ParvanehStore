<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "logo" => "mimes:png,jpg,jpeg,svg|max:15360" ,
            "name" => "required" ,
            "email" => "required" ,
            "mobileNumber" => "required" ,
            "phoneNumber" => "required" ,
            "description" => "required"
        ];
    }
}
