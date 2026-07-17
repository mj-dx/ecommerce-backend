<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(ProductResource::collection(Product::query()->paginate(15)), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $product = Product::create($request->only(['name', 'description', 'price', 'discount', 'sku', 'stock', 'status', 'category_id']));

        return response()->json(new ProductResource($product), 201);
    }
}
