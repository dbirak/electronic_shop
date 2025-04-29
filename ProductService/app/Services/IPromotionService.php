<?php

namespace App\Services;

use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;

interface IPromotionService
{
    public function storePromotion(StorePromotionRequest $request);

    public function updatePromotion(UpdatePromotionRequest $request, string $promotionId);

    public function destroyPromotion(string $promotionId);
}
