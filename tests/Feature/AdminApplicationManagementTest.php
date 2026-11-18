<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminApplicationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_api_requires_authentication(): void
    {
        $this->getJson('/api/admin/applications')
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated. Please log in to continue.');
        $this->patchJson('/api/admin/applications/1/status', [])->assertUnauthorized();
        $this->deleteJson('/api/admin/applications/1')->assertUnauthorized();
    }

    #[DataProvider('nonAdminRoles')]
    public function test_non_admin_users_are_forbidden(string $role): void
    {
        $application = $this->makeApplication();
        Sanctum::actingAs(User::factory()->create(['role' => $role]));

        $this->getJson('/api/admin/applications')->assertForbidden();
        $this->patchJson("/api/admin/applications/{$application->id}/status", [])->assertForbidden();
        $this->deleteJson("/api/admin/applications/{$application->id}")->assertForbidden();
    }

    public static function nonAdminRoles(): array
    {
        return [
            'job seeker' => ['job_seeker'],
            'company' => ['company'],
        ];
    }

    public function test_admin_can_list_applications(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $application = $this->makeApplication();

        $this->getJson('/api/admin/applications')
            ->assertOk()
            ->assertJsonPath('data.data.0.id', $application->id)
            ->assertJsonPath('data.data.0.user.name', 'Budi Santoso')
            ->assertJsonPath('data.data.0.job.title', 'Backend Developer')
            ->assertJsonPath('data.data.0.job.company.company_name', 'PT Contoh Nusantara');
    }

    public function test_status_filter_only_shows_selected_status(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $this->makeApplication(['status' => 'pending']);
        $this->makeApplication(['status' => 'accepted']);

        $this->getJson('/api/admin/applications?status=accepted')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.status', 'accepted');

        $this->getJson('/api/admin/applications?status=reviewed')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);
    }

    public function test_search_filters_by_applicant_or_job_title(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $this->makeApplication(['applicantName' => 'Siti Aminah', 'jobTitle' => 'Backend Developer']);
        $this->makeApplication(['applicantName' => 'Rudi Hartono', 'jobTitle' => 'UI UX Designer']);

        $this->getJson('/api/admin/applications?search=Siti')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.user.name', 'Siti Aminah');

        $this->getJson('/api/admin/applications?search=UI UX')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.job.title', 'UI UX Designer');
    }

    #[DataProvider('statusChanges')]
    public function test_admin_can_change_application_status(string $to): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $application = $this->makeApplication();

        $this->patchJson("/api/admin/applications/{$application->id}/status", ['status' => $to])
            ->assertOk()
            ->assertJsonPath('data.status', $to);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => $to,
        ]);
    }

    public static function statusChanges(): array
    {
        return [
            'terima' => ['accepted'],
            'tolak' => ['rejected'],
            'kembali menunggu' => ['pending'],
        ];
    }

    public function test_invalid_application_status_is_rejected(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $application = $this->makeApplication();

        $this->patchJson("/api/admin/applications/{$application->id}/status", ['status' => 'reviewed'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);

        $this->assertDatabaseHas('applications', [
            'id' => $application->id,
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_delete_application(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $application = $this->makeApplication();

        $this->deleteJson("/api/admin/applications/{$application->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Application deleted successfully.');

        $this->assertDatabaseMissing('applications', ['id' => $application->id]);
        $this->assertDatabaseHas('job_postings', ['id' => $application->job_id]);
        $this->assertDatabaseHas('users', ['id' => $application->user_id]);
    }

    private function makeApplication(array $attributes = []): Application
    {
        $companyUser = User::factory()->create(['role' => 'company']);
        $company = $companyUser->company()->create(['company_name' => 'PT Contoh Nusantara']);

        $job = $company->jobs()->create([
            'title' => $attributes['jobTitle'] ?? 'Backend Developer',
            'location' => 'Madiun',
            'employment_type' => 'Full-time',
            'description' => 'Membangun aplikasi.',
            'requirements' => 'Menguasai Laravel.',
            'status' => 'open',
        ]);

        $applicant = User::factory()->create([
            'name' => $attributes['applicantName'] ?? 'Budi Santoso',
            'role' => 'job_seeker',
        ]);

        return $applicant->applications()->create([
            'job_id' => $job->id,
            'status' => $attributes['status'] ?? 'pending',
        ]);
    }
}
