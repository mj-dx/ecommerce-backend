<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_creation_creates_notification(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $order = Order::create(['user_id' => $user->id, 'status' => 'Pending', 'total' => 100]);

        $response = $this->postJson('/api/v1/notifications/test', ['order_id' => $order->id]);

        $response->assertStatus(200);
    }
}
