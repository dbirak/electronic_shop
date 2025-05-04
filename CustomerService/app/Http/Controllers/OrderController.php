<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Services\IOrderService;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(IOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $res = $this->orderService->getOrder($request->user()->id, $request);
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
    public function store(StoreOrderRequest $request)
    {
        try {
            $res = $this->orderService->storeOrder($request->user()->id, $request);
            return response($res, 201);
        } catch (Exception $e) {
            if ($e instanceof NotFoundException)
                throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $orderId)
    {
        try {
            $res = $this->orderService->showOrder($request->user()->id, $orderId);
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
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $res = $this->orderService->destroyOrder($request->user()->id, $id);
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

    public function getActiveOrders()
    {
        try {
            $res = $this->orderService->getActiveOrders();
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof NotFoundException)
                throw $e;
        }
    }

    public function changeOrderStatus(ChangeOrderStatusRequest $request, string $orderId)
    {
        try {
            $res = $this->orderService->changeOrderStatus($request, $orderId);
            return response($res, 200);
        } catch (Exception $e) {
            if ($e instanceof NotFoundException)
                throw $e;
            if ($e instanceof ConflictException)
                throw $e;
        }
    }
}
