<?php

namespace App\Http\Resources\Panel;

use Illuminate\Http\Resources\Json\JsonResource;

class SocialMedia extends JsonResource
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
            "name" => $this->name ,
            "URL" => $this->url ,
            "updatedAt" => convertDateToFarsi($this->updated_at)
        ];
    }
}
