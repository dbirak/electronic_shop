<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Htt;

class ProductController extends Controller
{
    protected $productServiceUrl;

    public function __construct()
    {
        $this->productServiceUrl = env('PRODUCT_SERVICE_URL', 'http://localhost:8002/api');
    }

    public function index(SearchProductRequest $request)
    {
        $data = $request->all();

        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->get("{$this->productServiceUrl}/products", $data);

        $status = $response->status();

        if ($status >= 400) {
            return response()->json($response->json(), $status);
        }

        $body = $response->json();

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

    public function store(StoreProductRequest $request)
    {
        $multipart = $this->convertRequestToMultipart($request);

        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->asMultipart()
            ->post("{$this->productServiceUrl}/products", $multipart);

        return response()->json($response->json(), $response->status());
    }

    public function update(UpdateProductRequest $request, string $productId)
    {
        $multipart = $this->convertRequestToMultipart($request);

        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->asMultipart()
            ->post("{$this->productServiceUrl}/products/{$productId}", $multipart);

        return response()->json($response->json(), $response->status());

        return response()->json($response->json(), $response->status());
    }

    public function destroy(string $productId)
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->delete("{$this->productServiceUrl}/products/{$productId}");

        return response()->json(['message' => 'Produkt został usunięty'], $response->status());
    }

    public function show(string $productId)
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->get("{$this->productServiceUrl}/products/{$productId}");

        return response()->json($response->json(), $response->status());
    }

    public function getSearchDetails()
    {
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->get("{$this->productServiceUrl}/products/search/details");

        return response()->json($response->json(), $response->status());
    }

    public function getProducts(StoreProductRequest $request)
    {
        $data = $request->validated();
        $response = Http::withToken(env('ADMIN_TOKEN'))
            ->post("{$this->productServiceUrl}/products/get", $data);

        return response()->json($response->json(), $response->status());
    }

    public function convertRequestToMultipart($request)
    {
        $multipart = [];

        foreach ($request->except(array_keys($request->files->all())) as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $i => $item) {
                    $multipart[] = [
                        'name' => "{$key}[{$i}]",
                        'contents' => $item,
                    ];
                }
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => $value,
                ];
            }
        }

        foreach ($request->allFiles() as $key => $file) {
            if (is_array($file)) {
                foreach ($file as $i => $single) {
                    $multipart[] = [
                        'name' => "{$key}[{$i}]",
                        'contents' => fopen($single->getPathname(), 'r'),
                        'filename' => $single->getClientOriginalName(),
                    ];
                }
            } else {
                $multipart[] = [
                    'name' => $key,
                    'contents' => fopen($file->getPathname(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ];
            }
        }

        return $multipart;
    }
}
