<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeOrderStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    protected $orderServiceUrl;

    public function __construct()
    {
        $this->orderServiceUrl = env('ORDER_SERVICE_URL', 'http://localhost:8001/api');
    }

    public function getActiveOrders()
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->get("{$this->orderServiceUrl}/orders/active");

        return response()->json($response->json(), $response->status());
    }

    public function changeOrderStatus(ChangeOrderStatusRequest $request, string $orderId)
    {
        $data = $request->validated();

        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->patch("{$this->orderServiceUrl}/orders/{$orderId}/status", $data);

        return response()->json($response->json(), $response->status());
    }
}
