<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'category' => $this->category,
            'description' => $this->description,
            'image' => $this->image,
            'capacity' => $this->capacity,
            'size' => $this->size,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
