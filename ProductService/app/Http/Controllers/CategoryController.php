<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\ICategoryService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(ICategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = $this->categoryService->showCategories();
        return response($res, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $res = $this->categoryService->storeCategory($request, $request->user()->id);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $categoryId)
    {
        try {
            $res = $this->categoryService->showCategory($categoryId);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof AuthorizationException)
                throw $e;
            if ($e instanceof NotFoundException)
                throw $e;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        try {
            $res = $this->categoryService->updateCategory($request, $id);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof AuthorizationException)
                throw $e;
            if ($e instanceof NotFoundException)
                throw $e;
            if ($e instanceof ConflictException)
                throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $res = $this->categoryService->destroyCategory($id);
            return response($res, 204);
        } catch (Exception $e) {
            if ($e instanceof AuthorizationException)
                throw $e;
            if ($e instanceof NotFoundException)
                throw $e;
            if ($e instanceof ConflictException)
                throw $e;
        }
    }
}
