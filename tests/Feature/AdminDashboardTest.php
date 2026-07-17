<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard_statistics(): void
    {
        $user = User::factory()->create();
        $role = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Admin']);
        $user->assignRole($role);
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/v1/admin/dashboard');

        $response->assertStatus(200);
    }
}
