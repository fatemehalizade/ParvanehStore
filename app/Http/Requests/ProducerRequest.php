<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProducerRequest extends FormRequest
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
            "image" => $this->producer == null ? "required|mimes:png,jpg,jpeg|max:15360" : "nullable|image|mimes:png,jpg,jpeg|max:15360" ,
            "producerName" => "required|unique:producers,producer,".$this->producer ?? 0
        ];
    }
}
