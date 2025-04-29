<?php

namespace App\Repositories;

use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Product;
use App\Models\Promotion;

class PromotionRepository implements IPromotionRepository
{
    public function storePromotion(StorePromotionRequest $request)
    {
        $promotion = new Promotion();
        $promotion->new_price = $request["new_price"];
        $promotion->expiration_date = $request["expiration_date"];
        $promotion->save();

        $product = Product::where('id', $request["product_id"])->first();
        $product['promotion_id'] = $promotion->id;
        $product->save();

        return $promotion;
    }

    public function findPromotionById(string $promotionId)
    {
        return Promotion::where("id", $promotionId)->first();
    }

    public function updatePromotion(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $promotion->new_price = $request["new_price"];
        $promotion->expiration_date = $request["expiration_date"];
        $promotion->save();

        return $promotion;
    }

    public function destroyPromotion($promotionId)
    {
        Promotion::where('id', $promotionId)->delete();
    }
}
