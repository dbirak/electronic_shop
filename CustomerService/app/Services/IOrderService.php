<?php

namespace App\Services;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Requests\StoreOrderRequest;

interface IOrderService
{
    public function getOrder(int $userId);

    public function storeOrder(int $userId, StoreOrderRequest $request);

    public function destroyOrder(int $userId, string $orderId);

    public function showOrder(int $userId, string $orderId);

    public function getActiveOrders();

    public function changeOrderStatus(ChangeOrderStatusRequest $request, string $orderId);
}
