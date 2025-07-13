<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'operator'  => $this->operator,
            'price'  => $this->price,
            'formatted_price' => $this->formatted_price,
            'views' => $this->views,
            'location' => $this->location,
            'expires_at' => $this->expires_at->format('Y-m-d H:i:s'),
            'expires_at_human' => $this->expires_at->diffForHumans(),
            'image_url' => $this->image_url,
            'is_featured' => $this->is_featured,
            'is_expired' => $this->is_expired,
            'created_at'  => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
