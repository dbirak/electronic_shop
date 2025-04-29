<?php

namespace App\Repositories;

use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Promotion;

interface IPromotionRepository
{
    public function storePromotion(StorePromotionRequest $request);

    public function findPromotionById(string $promotionId);

    public function updatePromotion(UpdatePromotionRequest $request, Promotion $promotion);

    public function destroyPromotion($promotionId);
}
