<?php

namespace App\Repositories;

use App\Http\Requests\ChangeOrderStatusRequest;
use App\Http\Requests\StoreOrderRequest;

interface IOrderRepository
{
    public function getOrder(int $userId);

    public function storeOrder(int $userId, StoreOrderRequest $request, $products);

    public function findOrderById(string $orderId);

    public function destroyOrder(int $userId, string $orderId);

    public function getActiveOrders();

    public function changeOrderStatus(ChangeOrderStatusRequest $request, string $orderId);
}
