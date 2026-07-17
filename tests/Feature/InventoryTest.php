<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_update_stock(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'desc',
            'price' => 10,
            'discount' => 0,
            'sku' => 'INV-001',
            'stock' => 5,
            'status' => 'active',
        ]);

        $response = $this->postJson('/api/v1/inventory/stock', [
            'product_id' => $product->id,
            'quantity' => 10,
        ]);

        $response->assertStatus(200);
    }
}
