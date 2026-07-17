<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_categories(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/v1/categories');

        $response->assertStatus(200);
    }

    public function test_can_create_category(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/v1/categories', [
            'name' => 'Electronics',
            'slug' => 'electronics',
            'description' => 'Electronics category',
        ]);

        $response->assertStatus(201);
    }
}
