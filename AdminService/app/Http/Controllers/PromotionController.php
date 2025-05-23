<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use Illuminate\Support\Facades\Http;

class PromotionController extends Controller
{
    protected $promotionServiceUrl;

    public function __construct()
    {
        $this->promotionServiceUrl = env('PRODUCT_SERVICE_URL', 'http://localhost:8002/api');
    }

    public function store(StorePromotionRequest $request)
    {
        $data = $request->validated();
        $response = Http::withToken(env('ADMIN_TOKEN'))->accept('application/json')
            ->post("{$this->promotionServiceUrl}/promotions", $data);

        return response()->json($response->json(), $response->status());
    }

    public function update(UpdatePromotionRequest $request, string $id)
    {
        $data = $request->validated();
        $response = Http::withToken(env('ADMIN_TOKEN'))->accept('application/json')
            ->put("{$this->promotionServiceUrl}/promotions/{$id}", $data);

        return response()->json($response->json(), $response->status());
    }

    public function destroy(string $id)
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))->accept('application/json')
            ->delete("{$this->promotionServiceUrl}/promotions/{$id}");

        return response()->json(['message' => 'Promocja została usunięta'], $response->status());
    }
}
