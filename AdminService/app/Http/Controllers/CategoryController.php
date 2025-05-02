<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    protected $categoryServiceUrl;

    public function __construct()
    {
        $this->categoryServiceUrl = env('CATEGORY_SERVICE_URL', 'http://localhost:8002/api');
    }

    public function index()
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->get("{$this->categoryServiceUrl}/categories");

        return response()->json($response->json(), $response->status());
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->post("{$this->categoryServiceUrl}/categories", $data);

        return response()->json($response->json(), $response->status());
    }

    public function show(string $id)
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->get("{$this->categoryServiceUrl}/categories/{$id}");

        return response()->json($response->json(), $response->status());
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        $data = $request->validated();

        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->put("{$this->categoryServiceUrl}/categories/{$id}", $data);

        return response()->json($response->json(), $response->status());
    }

    public function destroy(string $id)
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->delete("{$this->categoryServiceUrl}/categories/{$id}");

        return response()->json(['message' => 'Kategoria została usunięta'], $response->status());
    }
}
