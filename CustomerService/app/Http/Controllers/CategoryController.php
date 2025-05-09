<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $categoryServiceUrl;

    public function __construct()
    {
        $this->categoryServiceUrl = env('PRODUCT_SERVICE_URL', 'http://localhost:8002/api');
    }

    public function index()
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))->accept('application/json')
            ->get("{$this->categoryServiceUrl}/categories");

        return response()->json($response->json(), $response->status());
    }

    public function show(string $id)
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))->accept('application/json')
            ->get("{$this->categoryServiceUrl}/categories/{$id}");

        return response()->json($response->json(), $response->status());
    }
}
