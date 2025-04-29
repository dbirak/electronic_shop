<?php

namespace App\Repositories;

use App\Http\Requests\SearchCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;

interface ICategoryRepository
{
    public function findCategoryById(string $categoryId);

    public function storeCategory(StoreCategoryRequest $request);

    public function showCategories();

    public function updateCategory(UpdateCategoryRequest $request, Category $category);

    public function destroyCategory(string $categoryId);
}
