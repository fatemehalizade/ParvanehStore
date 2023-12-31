<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id ,
            "image" => $this->image ,
            "fullName" => $this->full_name ,
            "email" => $this->email ,
            "nationalCode" => $this->national_code ,
            "mobileNumber" => $this->mobile_number ,
            "userName" => $this->username ,
            "createdAt" => $this->created_at ,
            "updatedAt" => convertDateToFarsi($this->updated_at)
        ];
    }
}
