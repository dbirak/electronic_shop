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
            'promotion' => $this->promotion_id ? new PromotionResource(Promotion::find($this->promotion_id)) : null,
            'image' => $this->image_id ? new ImageResource(Image::find($this->image_id)) : null,
            'category' => $this->category_id ? new CategoryResource(Category::find($this->category_id)) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
