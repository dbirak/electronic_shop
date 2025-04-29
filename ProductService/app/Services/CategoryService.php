<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SearchCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Repositories\ICategoryRepository;
use Illuminate\Auth\Access\AuthorizationException;

class CategoryService implements ICategoryService
{
    protected $categoryRepository;

    public function __construct(ICategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function storeCategory(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepository->storeCategory($request);

        return new CategoryResource($category);
    }

    public function updateCategory(UpdateCategoryRequest $request, string $categoryId)
    {
        $category = $this->categoryRepository->findCategoryById($categoryId);

        if (!isset($category)) throw new NotFoundException();

        $updatedCategory = $this->categoryRepository->updateCategory($request, $category);

        return new CategoryResource($updatedCategory);
    }

    public function destroyCategory(string $categoryId)
    {
        $category = $this->categoryRepository->findCategoryById($categoryId);

        if (!isset($category)) throw new NotFoundException();

        $this->categoryRepository->destroyCategory($categoryId);
    }

    public function showCategory(string $categoryId)
    {
        $category = $this->categoryRepository->findCategoryById($categoryId);

        if (!isset($category)) throw new NotFoundException();

        return new CategoryResource($category);
    }

    public function showCategories()
    {
        $categories = $this->categoryRepository->showCategories();

        return CategoryResource::collection($categories);
    }
}
