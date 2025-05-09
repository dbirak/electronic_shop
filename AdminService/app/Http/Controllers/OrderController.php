<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeOrderStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    protected $orderServiceUrl;

    public function __construct()
    {
        $this->orderServiceUrl = env('CUSTOMER_SERVICE_URL', 'http://localhost:8001/api');
    }

    public function getActiveOrders(Request $request)
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))->accept('application/json')
            ->get("{$this->orderServiceUrl}/orders/active");

        $status = $response->status();

        if ($status >= 400) {
            return response()->json($response->json(), $status);
        }

        $body = $response->json();

        return $body;

        if (!isset($body['meta'])) {
            return response()->json($body, $status);
        }

        $currentPage = $body['meta']['current_page'] ?? 1;
        $lastPage = $body['meta']['last_page'] ?? 1;

        $query = $request->query();

        $body['links']['self'] = request()->fullUrl();

        if ($currentPage < $lastPage) {
            $query['page'] = $currentPage + 1;
            $body['links']['next'] = url()->current() . '?' . http_build_query($query);
        } else {
            $body['links']['next'] = null;
        }

        if ($currentPage > 1) {
            $query['page'] = $currentPage - 1;
            $body['links']['prev'] = url()->current() . '?' . http_build_query($query);
        } else {
            $body['links']['prev'] = null;
        }

        return response()->json($body, $status);
    }

    public function changeOrderStatus(ChangeOrderStatusRequest $request, string $orderId)
    {
        $data = $request->validated();

        $response = Http::withToken(env('ADMIN_TOKEN'))->accept('application/json')
            ->patch("{$this->orderServiceUrl}/orders/{$orderId}/status", $data);

        return response()->json($response->json(), $response->status());
    }
}
