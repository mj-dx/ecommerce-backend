<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrdersTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_order_from_cart(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $product = Product::create([
            'name' => 'Order Product',
            'description' => 'desc',
            'price' => 50,
            'discount' => 0,
            'sku' => 'ORD-001',
            'stock' => 10,
            'status' => 'active',
        ]);

        $cart = Cart::create(['user_id' => $user->id]);
        $cart->items()->create(['product_id' => $product->id, 'quantity' => 1]);

        $response = $this->postJson('/api/v1/orders', []);

        $response->assertStatus(201);
    }
}
