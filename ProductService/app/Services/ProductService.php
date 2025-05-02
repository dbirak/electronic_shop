<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\GetProductRequest;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Repositories\IProductRepository;
use Illuminate\Auth\Access\AuthorizationException;

class ProductService implements IProductService
{

    protected $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function storeProduct(StoreProductRequest $request)
    {
        $product = $this->productRepository->storeProduct($request);

        return new ProductResource($product);
    }

    public function updateProduct(UpdateProductRequest $request, string $productId)
    {
        $product = $this->productRepository->findProductById($productId);

        if (!isset($product)) throw new NotFoundException();
        // if ($product['user_id'] !== $userId) throw new AuthorizationException();

        $updatedProduct = $this->productRepository->updateProduct($request, $product);

        return new ProductResource($updatedProduct);
    }

    public function destroyProduct(string $productId)
    {
        $product = $this->productRepository->findProductById($productId);

        if (!isset($product)) throw new NotFoundException();
        // if ($product['user_id'] !== $userId) throw new AuthorizationException();

        $this->productRepository->destroyProduct($productId);
    }

    public function showProduct(string $productId)
    {
        $product = $this->productRepository->findProductById($productId);

        if (!isset($product)) throw new NotFoundException();

        return new ProductResource($product);
    }

    public function getSearchDetails()
    {
        $searchDetails = $this->productRepository->getSearchDetails();

        return $searchDetails;
    }

    public function searchProduct(SearchProductRequest $request)
    {
        $products = $this->productRepository->searchProduct($request);

        return new ProductCollection($products);
    }

    public function getProducts(GetProductRequest $request)
    {
        $products = $this->productRepository->getProducts($request);

        $foundIds = $products->pluck('id')->all();
        $missingIds = array_diff($request['product_ids'], $foundIds);

        if (!empty($missingIds)) {
            throw new NotFoundException('Nie znaleziono produktów o ID: ' . implode(', ', $missingIds));
        }

        return $products;

        return ProductResource::collection($products);
    }
}
