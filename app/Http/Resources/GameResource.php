<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'image'         => $this->image,
            'description'   => $this->description,
            'attribute'     => new AttributeResource($this->attribute),
            'type'          => $this->type,
            'release_date'          => $this->release_date,
        ];
    }
}
