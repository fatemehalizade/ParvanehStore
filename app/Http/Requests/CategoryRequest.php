<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            "image" => $this->categoryId == 0 ? "required|mimes:jpeg,png,jpg|max:15360,".$this->category ?? 0 : "",
            "categoryName" => "required|unique:categories,name,".$this->category ?? 0 ,
            "categoryNickName" => "required|unique:categories,nick_name,".$this->category ?? 0 ,
            "categoryId" => "min:0"
        ];
    }
}
