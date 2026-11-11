<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ApiControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_registration_login_and_logout_issue_and_revoke_tokens(): void
    {
        $registration = $this->postJson('/api/auth/register', [
            'name' => 'Dewi Lestari',
            'email' => 'dewi@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'job_seeker',
        ]);

        $registration->assertCreated()
            ->assertJsonPath('data.user.email', 'dewi@example.test')
            ->assertJsonPath('data.user.role', 'job_seeker');

        $this->assertDatabaseHas('job_seeker_profiles', [
            'user_id' => $registration->json('data.user.id'),
        ]);

        $login = $this->postJson('/api/auth/login', [
            'email' => 'dewi@example.test',
            'password' => 'password123',
        ])->assertOk();

        $token = $login->json('data.token');
        $this->assertIsString($token);

        $this->withToken($token)
            ->getJson('/api/user')
            ->assertOk()
            ->assertJsonPath('email', 'dewi@example.test');

        $this->withToken($token)
            ->postJson('/api/auth/logout')
            ->assertOk();

        $this->withToken($token)
            ->getJson('/api/user')
            ->assertUnauthorized();
    }

    public function test_company_api_limits_job_operations_to_the_owning_company(): void
    {
        $companyUser = User::factory()->create(['role' => 'company']);
        $company = $companyUser->company()->create(['company_name' => 'PT Contoh']);
        $otherCompanyUser = User::factory()->create(['role' => 'company']);
        $otherCompany = $otherCompanyUser->company()->create(['company_name' => 'PT Lain']);

        $otherJob = $otherCompany->jobs()->create($this->jobAttributes());

        Sanctum::actingAs($companyUser);

        $this->getJson("/api/company/jobs/{$otherJob->id}")
            ->assertForbidden();

        $this->postJson('/api/company/jobs', $this->jobAttributes())
            ->assertCreated()
            ->assertJsonPath('data.title', 'Backend Developer');

        $this->assertDatabaseHas('job_postings', [
            'company_id' => $company->id,
            'title' => 'Backend Developer',
        ]);
    }

    public function test_job_seeker_api_lists_jobs_and_creates_applications_for_authenticated_user(): void
    {
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        $companyUser = User::factory()->create(['role' => 'company']);
        $company = $companyUser->company()->create(['company_name' => 'PT Contoh']);
        $job = $company->jobs()->create($this->jobAttributes());
        $otherJobSeeker = User::factory()->create(['role' => 'job_seeker']);

        Sanctum::actingAs($jobSeeker);

        $this->getJson('/api/job-seeker/jobs')
            ->assertOk()
            ->assertJsonPath('data.data.0.id', $job->id);

        $this->postJson("/api/job-seeker/jobs/{$job->id}/applications", [
            'cover_letter' => 'Saya memiliki pengalaman kerja backend selama lima tahun.',
        ])->assertCreated()
            ->assertJsonPath('data.user_id', $jobSeeker->id);

        $otherJobSeeker->applications()->create(['job_id' => $job->id]);

        $this->getJson('/api/job-seeker/applications')
            ->assertOk()
            ->assertJsonPath('data.data.0.user_id', $jobSeeker->id)
            ->assertJsonMissing(['user_id' => $otherJobSeeker->id]);
    }

    public function test_job_seeker_api_updates_profile_and_manages_cv_uploads(): void
    {
        Storage::fake('local');
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        Sanctum::actingAs($jobSeeker);

        $this->put('/api/job-seeker/profile', [
            'name' => 'Dewi Lestari',
            'email' => $jobSeeker->email,
            'phone' => '081234567890',
            'address' => 'Bandung',
            'education' => 'S1 Informatika',
            'cv' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
        ])->assertOk()
            ->assertJsonPath('data.user.name', 'Dewi Lestari')
            ->assertJsonPath('data.has_cv', true);

        $cvPath = $jobSeeker->jobSeekerProfile()->firstOrFail()->cv_path;
        $this->assertTrue(Storage::disk('local')->exists($cvPath));

        $this->deleteJson('/api/job-seeker/profile/cv')
            ->assertOk()
            ->assertJsonPath('data.has_cv', false);

        $this->assertFalse(Storage::disk('local')->exists($cvPath));
    }

    public function test_admin_api_requires_admin_role_and_returns_dashboard_data(): void
    {
        $this->getJson('/api/users')
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated. Please log in to continue.');
        $this->getJson('/api/users/1')
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated. Please log in to continue.');
        $this->postJson('/api/users', [])
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated. Please log in to continue.');

        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        Sanctum::actingAs($jobSeeker);

        $this->getJson('/api/admin/dashboard')->assertForbidden();
        $this->getJson('/api/users')->assertForbidden();
        $this->getJson("/api/users/{$jobSeeker->id}")->assertForbidden();
        $this->postJson('/api/users', [])->assertForbidden();

        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $this->getJson('/api/admin/dashboard')
            ->assertOk()
            ->assertJsonPath('data.user_count', 2);

        $this->getJson('/api/admin/users')
            ->assertOk()
            ->assertJsonPath('data.total', 2);

        $this->getJson('/api/users')
            ->assertOk()
            ->assertJsonPath('data.total', 2);

        $this->getJson("/api/users/{$jobSeeker->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $jobSeeker->id)
            ->assertJsonMissingPath('data.password');

        $this->postJson('/api/users', [
            'name' => 'Perusahaan Contoh',
            'email' => 'perusahaan@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'company',
            'company_name' => 'PT Contoh',
        ])->assertCreated()
            ->assertJsonPath('data.email', 'perusahaan@example.test')
            ->assertJsonPath('data.role', 'company')
            ->assertJsonMissingPath('data.password');

        $this->assertDatabaseHas('companies', [
            'company_name' => 'PT Contoh',
        ]);
    }

    public function test_shuttle_api_keeps_reads_public_and_requires_admin_for_writes(): void
    {
        $this->getJson('/api/shuttles')->assertOk();
        $this->postJson('/api/shuttles', [])
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated. Please log in to continue.');

        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $this->postJson('/api/shuttles', [
            'nama_armada' => 'Bus Kampus',
            'kapasitas' => 40,
            'rute_operasional' => 'Rektorat - Fakultas Teknik',
        ])->assertCreated()
            ->assertJsonPath('data.nama_armada', 'Bus Kampus');
    }

    /**
     * @return array<string, int|string>
     */
    private function jobAttributes(): array
    {
        return [
            'title' => 'Backend Developer',
            'location' => 'Madiun',
            'employment_type' => 'Full-time',
            'salary_min' => 5000000,
            'salary_max' => 10000000,
            'description' => 'Membangun aplikasi.',
            'requirements' => 'Menguasai Laravel.',
            'status' => 'open',
        ];
    }
}
