<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Repositories\IOrderRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Http;

class OrderService implements IOrderService
{
    protected $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrder(int $userId)
    {
        $order = $this->orderRepository->getOrder($userId);

        return new OrderCollection($order);
    }

    public function storeOrder(int $userId, StoreOrderRequest $request)
    {
        $response = Http::post(env('PRODUCT_SERVICE_URL') . '/products/get', [
            'product_ids' => $request['product_ids']
        ]);

        if ($response->status() !== 200) {
            throw new NotFoundException("Nie znaleziono produktów.");
        }

        $products = $response->json();

        $order = $this->orderRepository->storeOrder($userId, $request, $products);

        return new OrderResource($order);
    }

    public function destroyOrder(int $userId, string $orderId)
    {
        $order = $this->orderRepository->findOrderById($orderId);

        if (!isset($order)) throw new NotFoundException();
        if ($order['user_id'] !== $userId) throw new AuthorizationException();
        if ($order['status'] !== 'pending') throw new AuthorizationException();

        $this->orderRepository->destroyOrder($userId, $orderId);
    }

    public function showOrder(int $userId, string $orderId)
    {
        $order = $this->orderRepository->findOrderById($userId, $orderId);

        if (!isset($order)) throw new NotFoundException();
        if ($order['user_id'] !== $userId) throw new AuthorizationException();

        return new OrderResource($order);
    }
}
