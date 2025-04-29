<?php

namespace App\Repositories;

use App\Http\Requests\GetProductRequest;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

interface IProductRepository
{
    public function getAllProducts();

    public function findProductById(string $productId);

    public function storeProduct(StoreProductRequest $request);

    public function searchProduct(SearchProductRequest $request);

    public function getSearchDetails();

    public function updateProduct(UpdateProductRequest $request, Product $product);

    public function destroyProduct(string $productId);

    public function deletePromotion(int $productId);

    public function getProducts(GetProductRequest $request);
}
