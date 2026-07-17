<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    public function sendTest(Request $request): JsonResponse
    {
        $order = Order::findOrFail($request->input('order_id'));
        $order->user->notify(new class($order) extends Notification {
            public function __construct(private Order $order) {}

            public function via($notifiable): array
            {
                return ['database'];
            }

            public function toDatabase($notifiable): array
            {
                return ['message' => 'Order #' . $this->order->id . ' is being processed'];
            }
        });

        return response()->json(['message' => 'Notification sent'], 200);
    }
}
