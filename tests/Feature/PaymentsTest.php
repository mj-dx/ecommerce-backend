<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_payment_record(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $order = Order::create(['user_id' => $user->id, 'status' => 'Pending', 'total' => 100]);

        $response = $this->postJson('/api/v1/payments', ['order_id' => $order->id, 'method' => 'cash_on_delivery']);

        $response->assertStatus(201);
    }
}
