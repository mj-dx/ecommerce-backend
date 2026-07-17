<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_review_for_purchased_product(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $product = Product::create([
            'name' => 'Review Product',
            'description' => 'desc',
            'price' => 20,
            'discount' => 0,
            'sku' => 'REV-001',
            'stock' => 5,
            'status' => 'active',
        ]);

        $order = Order::create(['user_id' => $user->id, 'status' => 'Completed', 'total' => 20]);
        $order->items()->create(['product_id' => $product->id, 'quantity' => 1, 'price' => 20]);

        $response = $this->postJson('/api/v1/reviews', ['product_id' => $product->id, 'rating' => 5, 'comment' => 'Great product']);

        $response->assertStatus(201);
    }
}
