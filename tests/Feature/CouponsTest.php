<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CouponsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_coupon(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('/api/v1/coupons', [
            'code' => 'SAVE10',
            'type' => 'percentage',
            'value' => 10,
            'expires_at' => now()->addDay()->toDateString(),
            'usage_limit' => 5,
        ]);

        $response->assertStatus(201);
    }
}
