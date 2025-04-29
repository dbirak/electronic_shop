<?php

namespace App\Services;

use App\Http\Requests\SearchCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

interface ICategoryService
{
    public function storeCategory(StoreCategoryRequest $request);

    public function updateCategory(UpdateCategoryRequest $request, string $categoryId);

    public function destroyCategory(string $categoryId);

    public function showCategory(string $categoryId);

    public function showCategories();
}
