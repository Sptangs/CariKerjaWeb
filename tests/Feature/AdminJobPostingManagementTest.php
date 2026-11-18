<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminJobPostingManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_api_requires_authentication(): void
    {
        $this->getJson('/api/admin/jobs')
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated. Please log in to continue.');
        $this->patchJson('/api/admin/jobs/1/status', [])->assertUnauthorized();
        $this->deleteJson('/api/admin/jobs/1')->assertUnauthorized();
    }

    #[DataProvider('nonAdminRoles')]
    public function test_non_admin_users_are_forbidden(string $role): void
    {
        $job = $this->createJobPosting();
        Sanctum::actingAs(User::factory()->create(['role' => $role]));

        $this->getJson('/api/admin/jobs')->assertForbidden();
        $this->putJson("/api/admin/jobs/{$job->id}", [])->assertForbidden();
        $this->deleteJson("/api/admin/jobs/{$job->id}")->assertForbidden();
    }

    public static function nonAdminRoles(): array
    {
        return [
            'job seeker' => ['job_seeker'],
            'company' => ['company'],
        ];
    }

    public function test_admin_can_list_job_postings_with_counts(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $job = $this->createJobPosting(['title' => 'Backend Developer']);
        $applicant = User::factory()->create(['role' => 'job_seeker']);
        $applicant->applications()->create(['job_id' => $job->id]);

        $this->getJson('/api/admin/jobs')
            ->assertOk()
            ->assertJsonPath('data.data.0.id', $job->id)
            ->assertJsonPath('data.data.0.company.company_name', 'PT Contoh Nusantara')
            ->assertJsonPath('data.data.0.applications_count', 1);
    }

    public function test_status_filter_only_shows_selected_status(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $this->createJobPosting(['title' => 'Lowongan Terbuka', 'status' => 'open']);
        $this->createJobPosting(['title' => 'Lowongan Tertutup', 'status' => 'closed']);

        $this->getJson('/api/admin/jobs?status=closed')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.title', 'Lowongan Tertutup');

        $this->getJson('/api/admin/jobs?status=archived')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);
    }

    public function test_search_and_company_filter_narrow_the_list(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $frontend = $this->createJobPosting(['title' => 'Frontend Developer', 'location' => 'Surabaya']);
        $this->createJobPosting(['title' => 'Data Analyst', 'location' => 'Madiun']);

        $this->getJson('/api/admin/jobs?search=frontend')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.title', 'Frontend Developer');

        $this->getJson('/api/admin/jobs?search=Madiun')
            ->assertOk()
            ->assertJsonPath('data.data.0.title', 'Data Analyst');

        $this->getJson("/api/admin/jobs?company={$frontend->company_id}")
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.id', $frontend->id);
    }

    public function test_admin_can_view_job_posting_detail(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $job = $this->createJobPosting();

        $this->getJson("/api/admin/jobs/{$job->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $job->id)
            ->assertJsonPath('data.title', 'Backend Developer')
            ->assertJsonPath('data.applications_count', 0);
    }

    public function test_admin_can_update_job_posting(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $job = $this->createJobPosting();

        $this->putJson("/api/admin/jobs/{$job->id}", [
            'title' => 'Senior Backend Developer',
            'location' => 'Jakarta',
            'employment_type' => 'Kontrak',
            'salary_min' => 5000000,
            'salary_max' => 8000000,
            'description' => 'Membangun layanan backend.',
            'requirements' => 'Menguasai PHP dan MySQL.',
            'status' => 'open',
        ])->assertOk()
            ->assertJsonPath('data.title', 'Senior Backend Developer');

        $this->assertDatabaseHas('job_postings', [
            'id' => $job->id,
            'title' => 'Senior Backend Developer',
            'location' => 'Jakarta',
            'status' => 'open',
        ]);
    }

    public function test_invalid_status_when_updating_is_rejected(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $job = $this->createJobPosting();

        $this->putJson("/api/admin/jobs/{$job->id}", [
            'title' => $job->title,
            'location' => $job->location,
            'employment_type' => $job->employment_type,
            'description' => $job->description,
            'requirements' => $job->requirements,
            'status' => 'archived',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);

        $this->assertDatabaseHas('job_postings', [
            'id' => $job->id,
            'status' => 'open',
        ]);
    }

    #[DataProvider('statusChanges')]
    public function test_admin_can_change_job_posting_status(string $from, string $to): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $job = $this->createJobPosting(['status' => $from]);

        $this->patchJson("/api/admin/jobs/{$job->id}/status", ['status' => $to])
            ->assertOk()
            ->assertJsonPath('data.status', $to);

        $this->assertDatabaseHas('job_postings', [
            'id' => $job->id,
            'status' => $to,
        ]);
    }

    public static function statusChanges(): array
    {
        return [
            'tutup lowongan' => ['open', 'closed'],
            'buka lowongan' => ['closed', 'open'],
        ];
    }

    public function test_unknown_status_is_rejected(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $job = $this->createJobPosting();

        $this->patchJson("/api/admin/jobs/{$job->id}/status", ['status' => 'archived'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);

        $this->assertDatabaseHas('job_postings', [
            'id' => $job->id,
            'status' => 'open',
        ]);
    }

    public function test_admin_can_delete_job_posting_with_applications(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $job = $this->createJobPosting();
        $applicant = User::factory()->create(['role' => 'job_seeker']);
        $application = $applicant->applications()->create(['job_id' => $job->id]);

        $this->deleteJson("/api/admin/jobs/{$job->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Job posting and its applications deleted successfully.');

        $this->assertDatabaseMissing('applications', ['id' => $application->id]);
        $this->assertDatabaseMissing('job_postings', ['id' => $job->id]);
        $this->assertDatabaseHas('companies', ['id' => $job->company_id]);
    }

    private function createJobPosting(array $attributes = []): JobPosting
    {
        $companyUser = User::factory()->create(['role' => 'company']);
        $company = $companyUser->company()->create(['company_name' => 'PT Contoh Nusantara']);

        return $company->jobs()->create(array_merge([
            'title' => 'Backend Developer',
            'location' => 'Madiun',
            'employment_type' => 'Full-time',
            'description' => 'Membangun aplikasi.',
            'requirements' => 'Menguasai Laravel.',
            'status' => 'open',
        ], $attributes));
    }
}
