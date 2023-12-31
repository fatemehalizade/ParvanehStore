<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $id=0;
        if(!empty($this->admin)){
            $id=$this->admin;
        }
        else if(!empty($this->customer)){
            $id=$this->customer;
        }
        else if(!empty($this->user)){
            $id=$this->user;
        }
        return [
            "image" => "nullable|mimes:png,jpg,jpeg,gif|max:15360" ,
            "fullName" => "required" ,
            // Rule::unique('table name')->ignore('user id');
            "email" => "required|unique:users,email,".$id ?? 0 ,
            "mobileNumber" => "required|size:11" ,
            "nationalCode" => "required|size:10" ,
            // Rule::unique('table name')->ignore('user id');
            "username" => "required|unique:users,username,{$id}|min:6|max:20",
            // Rule::unique('table name')->ignore('user id');
            "password" => "required|unique:users,password,{$id}|min:6|max:20"
        ];
    }
}
