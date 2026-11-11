<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $jobSeeker = User::factory()->create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'role' => 'job_seeker',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('Manajemen Pengguna')
            ->assertSee($jobSeeker->name)
            ->assertSee($jobSeeker->email);
    }

    #[DataProvider('nonAdminRoles')]
    public function test_non_admin_users_are_forbidden(string $role): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->actingAs($user)
            ->get(route('admin.users.index'))
            ->assertForbidden();
    }

    public static function nonAdminRoles(): array
    {
        return [
            'job seeker' => ['job_seeker'],
            'company' => ['company'],
        ];
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get(route('admin.users.index'))
            ->assertRedirect(route('login'));
    }

    public function test_search_filters_by_name_or_email(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create(['name' => 'Alice Wijaya', 'email' => 'alice@example.com', 'role' => 'job_seeker']);
        User::factory()->create(['name' => 'Bob Pratama', 'email' => 'bob@example.com', 'role' => 'job_seeker']);

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['search' => 'alice']))
            ->assertOk()
            ->assertSee('Alice Wijaya')
            ->assertDontSee('Bob Pratama');

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['search' => 'bob@example.com']))
            ->assertOk()
            ->assertSee('Bob Pratama')
            ->assertDontSee('Alice Wijaya');
    }

    public function test_role_filter_only_shows_selected_role(): void
    {
        $admin = User::factory()->create(['name' => 'Admin Satu', 'email' => 'admin-satu@example.com', 'role' => 'admin']);
        User::factory()->create(['name' => 'Pelamar Satu', 'email' => 'pelamar@example.com', 'role' => 'job_seeker']);
        User::factory()->create(['name' => 'Perusahaan Satu', 'email' => 'perusahaan@example.com', 'role' => 'company']);

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['role' => 'company']))
            ->assertOk()
            ->assertSee('perusahaan@example.com')
            ->assertDontSee('pelamar@example.com')
            ->assertDontSee('admin-satu@example.com');
    }

    public function test_invalid_role_filter_is_rejected(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.users.index', ['role' => 'superadmin']))
            ->assertSessionHasErrors('role');
    }

    public function test_user_passwords_are_not_rendered(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);

        $this->actingAs($admin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertDontSee($jobSeeker->password);
    }
}
