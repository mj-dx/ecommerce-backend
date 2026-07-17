<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RolesPermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_user_can_access_admin_endpoint(): void
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $permission = Permission::create(['name' => 'manage users']);
        $adminRole->givePermissionTo($permission);

        $user = User::factory()->create();
        $user->assignRole($adminRole);
        $user->givePermissionTo($permission);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/admin/users');

        $response->assertStatus(200)
            ->assertJson(['message' => 'Admin access granted.']);
    }

    public function test_customer_without_permission_cannot_access_admin_endpoint(): void
    {
        $customerRole = Role::create(['name' => 'Customer']);
        $user = User::factory()->create();
        $user->assignRole($customerRole);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/admin/users');

        $response->assertStatus(403);
    }
}
