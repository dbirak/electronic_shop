<?php

namespace App\Repositories;

use App\Http\Requests\StoreOrderRequest;

interface IOrderRepository
{
    public function getOrder(int $userId);

    public function storeOrder(int $userId, StoreOrderRequest $request);

    public function findOrderById(string $orderId);

    public function destroyOrder(int $userId, string $orderId);
}
