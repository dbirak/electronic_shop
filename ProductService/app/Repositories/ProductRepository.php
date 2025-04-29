<?php

namespace App\Repositories;

use App\Http\Requests\GetProductRequest;
use App\Http\Requests\SearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\Storage;

class ProductRepository
{
    public function storeProduct(StoreProductRequest $request)
    {
        $main_image = "";
        $additional_images = [];

        if ($request->has('main_image')) {

            $image = $request['main_image'];
            $path2 = $image->store('public/products/main_images');
            $filename_image = $image->hashName();

            $main_image = $filename_image;
        }

        if ($request->has('additional_images')) {
            foreach ($request["additional_images"] as $additional_image) {
                $image = $additional_image;
                $path2 = $image->store('public/products/additional_images');
                $filename_image = $image->hashName();

                $additional_images[] = $filename_image;
            }
        }

        $images = new Image();
        $images->main_image = $main_image;
        $images->additional_images = json_encode($additional_images);
        $images->save();

        $product = new Product();
        $product->name = $request["name"];
        $product->description = $request["description"];
        $product->price = $request["price"];
        $product->image_id = $images->id;
        $product->category_id = $request["category_id"];
        $product->save();

        return $product;
    }

    public function findProductById(string $productId)
    {
        return Product::where("id", $productId)->where('is_deleted', false)->first();
    }

    public function updateProduct(UpdateProductRequest $request, Product $product)
    {
        $main_image = $product['main_image'];
        $additional_images = json_decode($product['additional_images']);

        if ($request->has('main_image')) {
            if (Storage::exists('public/products/main_images/' . $product['main_image']))
                Storage::delete('public/products/main_images/' . $product['main_image']);

            $image = $request['main_image'];
            $path2 = $image->store('public/products/main_images');
            $filename_image = $image->hashName();

            $main_image = $filename_image;
        }

        if ($request->has('deleted_images')) {
            foreach ($request['deleted_images'] as $deleted_image) {
                if (Storage::exists('public/products/additional_images/' . $deleted_image))
                    Storage::delete('public/products/additional_images/' . $deleted_image);

                $key = array_search($deleted_image, $additional_images);
                if ($key !== false) unset($additional_images[$key]);
            }

            $additional_images = array_values($additional_images);
        }
        if ($request->has('additional_images')) {
            foreach ($request["additional_images"] as $additional_image) {
                $image = $additional_image;
                $path2 = $image->store('public/products/additional_images');
                $filename_image = $image->hashName();

                $additional_images[] = $filename_image;
            }
        }

        $images = Image::where("id", $product->image_id)->first();
        $images->main_image = $main_image;
        $images->additional_images = json_encode($additional_images);
        $images->save();

        $product->name = $request["name"];
        $product->description = $request["description"];
        $product->price = $request["price"];
        $product->image_id = $images->id;
        $product->category_id = $request["category_id"];
        $product->save();

        return $product;
    }

    public function destroyProduct($productId)
    {
        $product = Product::where('id', $productId)->first();

        if (Storage::exists('public/products/main_images/' . $product['main_image']))
            Storage::delete('public/products/main_images/' . $product['main_image']);

        $additional_images = json_decode($product['additional_images']);
        foreach ($additional_images as $additional_image) {
            if (Storage::exists('public/products/additional_images/' . $additional_image))
                Storage::delete('public/products/additional_images/' . $additional_image);
        }

        $product->is_deleted = true;
        $product->save();
    }

    public function searchProduct(SearchProductRequest $request)
    {
        $query = Product::query();

        if (!isset($request['order_by'])) $query->orderBy("created_at", "desc");
        else {
            if ($request['order_by'] === "price_desc") $query->orderBy("price", "desc");
            else if ($request['order_by'] === "price_asc") $query->orderBy("price", "asc");
            else if ($request["order_by"] === "created_at_desc") $query->orderBy("created_at", "desc");
            else if ($request["order_by"] === "created_at_desc") $query->orderBy("created_at", "asc");
        }

        if (
            !isset($request['category'])
        ) {
            return $query->where('is_deleted', false)->paginate(20);
        }

        if (isset($request['query'])) {
            $queryStrings = explode(' ', $request['query']);

            $query->where(function ($q) use ($queryStrings) {
                foreach ($queryStrings as $queryString) {
                    $q->orWhere('name', 'like', '%' . $queryString . '%')
                        ->orWhere('description', 'like', '%' . $queryString . '%');
                }
            });
        }
        if (isset($request['category'])) $query->where('category_id', $request['category']);

        return $query->where('is_active', true)->where("is_payed", true)->where('is_deleted', false)->paginate(20);
    }

    public function getSearchDetails()
    {
        $category = Category::all();

        return ["categories" => $category];
    }

    public function deletePromotion(int $productId)
    {
        $product = Product::where('id', $productId)->first();
        if ($product['promotion_id'] !== null) Promotion::where('product_id', $productId)->delete();
        $product->promotion_id = null;
        $product->save();
    }

    public function getProducts(GetProductRequest $request)
    {
        $productIds = $request->get('product_ids', []);

        return Product::whereIn('id', $productIds)
            ->where('is_deleted', false)
            ->get();
    }
}
