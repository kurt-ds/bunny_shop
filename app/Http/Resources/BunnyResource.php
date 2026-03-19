<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BunnyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'category' => $this->category->slug ?? 'uncategorized',
            'category_name' => $this->category ? $this->category->name : 'Uncategorized',
            'name' => $this->name,
            'price' => (float) $this->price,
            'image_url' => $this->image_url,
            'gender' => $this->gender,
            'age' => $this->age_months,
            'description' => $this->description,
            'is_sold' => $this->is_sold
        ];
    }
}
