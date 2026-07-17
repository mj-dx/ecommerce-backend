<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $order = Order::findOrFail($request->input('order_id'));
        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => $request->input('method', 'cash_on_delivery'),
            'status' => 'pending',
            'amount' => $order->total,
        ]);

        return response()->json(['message' => 'Payment created', 'payment' => $payment], 201);
    }
}
