<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{

    public static $wrap = null;
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {        
        $data = [
            "kind"          => $this->kind,
            "size_max"      => $this->size_max,
            "age_max"       => $this->age_max,
            "grow_factor"   => $this->grow_factor,
            "avatar"        => Storage::disk('avatar')->url($this->avatar) . '.png'
        ];
        
        return $data;
    }

    // public function with($request)
    // {
    //     return ['status' => 'success'];
    // }
}
