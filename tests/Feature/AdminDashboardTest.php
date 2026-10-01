<?php

namespace Tests\Feature;

use App\Models\User;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    public function test_admin_can_view_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Admin');
    }

    #[DataProvider('nonAdminRoles')]
    public function test_non_admin_users_are_forbidden_from_admin_dashboard(string $role): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public static function nonAdminRoles(): array
    {
        return [
            'job seeker' => ['job_seeker'],
            'company' => ['company'],
        ];
    }

    public function test_guest_is_redirected_to_login_from_admin_dashboard(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_login_redirects_to_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
    }

    public function test_public_registration_cannot_assign_admin_role(): void
    {
        $this->post(route('register'), [
            'name' => 'Unauthorized Admin',
            'email' => 'unauthorized-admin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ])->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', [
            'email' => 'unauthorized-admin@example.com',
        ]);
    }
}
