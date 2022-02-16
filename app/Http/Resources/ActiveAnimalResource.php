<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActiveAnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            "kind"      => $this->kind,
            "name"      => $this->name,
            "size"      => $this->size,
            "age"       => $this->age,
            "avatar"    => $this->avatar()     
        ];

        return $data;
    }
}
