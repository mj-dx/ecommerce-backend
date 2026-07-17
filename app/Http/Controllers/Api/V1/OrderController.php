<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();
        if (! $cart || $cart->items()->count() === 0) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        $order = Order::create([
            'user_id' => $request->user()->id,
            'status' => 'Pending',
            'total' => 0,
        ]);

        $total = 0;
        foreach ($cart->items as $item) {
            $price = $item->product->price;
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $price,
            ]);
            $total += $price * $item->quantity;
        }

        $order->update(['total' => $total]);
        $cart->items()->delete();

        return response()->json(['message' => 'Order created', 'order' => $order->load('items')], 201);
    }
}
