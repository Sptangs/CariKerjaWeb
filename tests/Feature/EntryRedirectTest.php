<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class EntryRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_home(): void
    {
        $this->get(route('home'))
            ->assertRedirect(route('login'));
    }

    #[DataProvider('roleDashboardRoutes')]
    public function test_authenticated_user_is_redirected_to_dashboard_for_role(string $role, string $dashboardRoute): void
    {
        $user = User::factory()->create(['role' => $role]);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertRedirect(route($dashboardRoute));
    }

    public static function roleDashboardRoutes(): array
    {
        return [
            'job seeker' => ['job_seeker', 'job-seeker.dashboard'],
            'company' => ['company', 'company.dashboard'],
            'admin' => ['admin', 'admin.dashboard'],
        ];
    }
}
