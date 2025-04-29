<?php

namespace App\Services;

use App\Http\Requests\GetProductRequest;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

interface IProductService
{
    public function storeProduct(StoreProductRequest $request);

    public function updateProduct(UpdateProductRequest $request, string $productId);

    public function destroyProduct(string $productId);

    public function showProduct(string $productId);

    public function getSearchDetails();

    public function searchProduct(SearchProductRequest $request);

    public function getProducts(GetProductRequest $request);
}
