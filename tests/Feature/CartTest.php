<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_add_item_to_cart(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $product = Product::create([
            'name' => 'Cart Product',
            'description' => 'desc',
            'price' => 20,
            'discount' => 0,
            'sku' => 'CART-001',
            'stock' => 10,
            'status' => 'active',
        ]);

        $response = $this->postJson('/api/v1/cart/items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response->assertStatus(200);
    }
}
