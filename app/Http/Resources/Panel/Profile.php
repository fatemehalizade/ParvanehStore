<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
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
            "logo" => $this->logo ,
            "name" => $this->name ,
            "email" => $this->email ,
            "mobileNumber" => $this->mobile_number ,
            "phoneNumber" => $this->phone_number ,
            "address" => $this->address ,
            "description" => $this->description ,
            "updatedAt" => convertDateToFarsi($this->updated_at)
        ];
    }
}
