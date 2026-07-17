<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(CategoryResource::collection(Category::all()), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $category = Category::create($request->only(['name', 'slug', 'description', 'parent_id']));

        return response()->json(new CategoryResource($category), 201);
    }
}
