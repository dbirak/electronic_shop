<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Services\IPromotionService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(IPromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePromotionRequest $request)
    {
        $res = $this->promotionService->storePromotion($request);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(UpdatePromotionRequest $request, string $id)
    {
        try {
            $res = $this->promotionService->updatePromotion($request, $id);
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
            $res = $this->promotionService->destroyPromotion($id);
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
