<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Http\Resources\PromotionResource;
use App\Repositories\IProductRepository;
use App\Repositories\IPromotionRepository;

class PromotionService implements IPromotionService
{
    protected $promotionRepository;
    protected $productRepository;

    public function __construct(IPromotionRepository $promotionRepository, IProductRepository $productRepository)
    {
        $this->promotionRepository = $promotionRepository;
        $this->productRepository = $productRepository;
    }

    public function storePromotion(StorePromotionRequest $request)
    {
        $this->productRepository->deletePromotion($request['product_id']);

        $promotion = $this->promotionRepository->storePromotion($request);

        return new PromotionResource($promotion);
    }

    public function updatePromotion(UpdatePromotionRequest $request, string $promotionId)
    {
        $promotion = $this->promotionRepository->findPromotionById($promotionId);

        if (!isset($promotion)) throw new NotFoundException();

        $updatedPromotion = $this->promotionRepository->updatePromotion($request, $promotion);

        return new PromotionResource($updatedPromotion);
    }

    public function destroyPromotion(string $promotionId)
    {
        $promotion = $this->promotionRepository->findPromotionById($promotionId);

        if (!isset($promotion)) throw new NotFoundException();

        $this->promotionRepository->destroyPromotion($promotionId);
    }
}
