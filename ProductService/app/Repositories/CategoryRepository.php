<?php

namespace App\Repositories;

use App\Exceptions\NotFoundException;
use App\Http\Requests\SearchCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Repositories\ICategoryRepository;
use Illuminate\Auth\Access\AuthorizationException;

class CategoryRepository implements ICategoryRepository
{
    public function storeCategory(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request["name"];
        $category->save();

        return $category;
    }

    public function findCategoryById(string $categoryId)
    {
        return Category::where("id", $categoryId)->first();
    }

    public function updateCategory(UpdateCategoryRequest $request, Category $category)
    {
        $category->name = $request["name"];
        $category->save();

        return $category;
    }

    public function destroyCategory($categoryId)
    {
        $category = Category::where('id', $categoryId)->delete();
    }

    public function showCategories()
    {
        return Category::all();
    }
}
