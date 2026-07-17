<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_products(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/v1/products');

        $response->assertStatus(200);
    }

    public function test_can_create_product(): void
    {
        $category = Category::create(['name' => 'Phones', 'slug' => 'phones']);
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/v1/products', [
            'name' => 'Phone X',
            'description' => 'Great phone',
            'price' => 999.99,
            'discount' => 10,
            'sku' => 'PHX-001',
            'stock' => 25,
            'status' => 'active',
            'category_id' => $category->id,
        ]);

        $response->assertStatus(201);
    }
}
