<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function updateStock(Request $request): JsonResponse
    {
        $product = Product::findOrFail($request->input('product_id'));
        $inventory = Inventory::firstOrCreate(['product_id' => $product->id], ['stock' => 0, 'reserved' => 0]);
        $inventory->stock += (int) $request->input('quantity');
        $inventory->save();

        return response()->json(['message' => 'Stock updated', 'stock' => $inventory->stock], 200);
    }
}
