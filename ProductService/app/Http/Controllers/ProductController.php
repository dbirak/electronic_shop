<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\GetProductRequest;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\IProductService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\Routing\Generator\Dumper\GeneratorDumperInterface;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(IProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchProductRequest $request)
    {
        $res = $this->productService->searchProduct($request);
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
    public function store(StoreProductRequest $request)
    {
        $res = $this->productService->storeProduct($request);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $productId)
    {
        try {
            $res = $this->productService->showProduct($productId);
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
    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $res = $this->productService->updateProduct($request, $id);
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
    public function destroy(Request $request, string $id)
    {
        try {
            $res = $this->productService->destroyProduct($id);
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

    public function getSearchDetails()
    {
        try {
            $res = $this->productService->getSearchDetails();
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof NotFoundException)
                throw $e;
            if ($e instanceof AuthorizationException)
                throw $e;
        }
    }

    public function getProduct(GetProductRequest $request)
    {
        try {
            $res = $this->productService->getProducts($request);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof NotFoundException)
                throw $e;
            if ($e instanceof AuthorizationException)
                throw $e;
        }
    }
}
