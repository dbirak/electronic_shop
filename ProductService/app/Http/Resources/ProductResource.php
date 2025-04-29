<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Image;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'promotion' => new PromotionResource(Promotion::findOrFail($this->promotion_id)),
            'image' => new ImageResource(Image::findOrFail($this->image_id)),
            'category' => new CategoryResource(Category::findOrFail($this->category_id)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
