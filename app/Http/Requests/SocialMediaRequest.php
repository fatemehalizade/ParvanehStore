<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialMediaRequest extends FormRequest
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
            "image" => $this->media == null ? "required|mimes:png,jpg,jpeg|max:15360" : "nullable|mimes:png,jpg,jpeg|max:15360" ,
            "name" => "required|unique:social_media,name,".$this->media ?? 0 ,
            "URL" => "required|unique:social_media,url,".$this->media ?? 0 ,
        ];
    }
}
