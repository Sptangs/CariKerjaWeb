<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminCompanyManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_api_requires_authentication(): void
    {
        $this->getJson('/api/admin/companies')
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated. Please log in to continue.');
        $this->putJson('/api/admin/companies/1', [])->assertUnauthorized();
        $this->deleteJson('/api/admin/companies/1')->assertUnauthorized();
    }

    #[DataProvider('nonAdminRoles')]
    public function test_non_admin_users_are_forbidden(string $role): void
    {
        $company = $this->createCompany('PT Contoh', 'hrd@contoh.test');
        Sanctum::actingAs(User::factory()->create(['role' => $role]));

        $this->getJson('/api/admin/companies')->assertForbidden();
        $this->putJson("/api/admin/companies/{$company->id}", [])->assertForbidden();
        $this->deleteJson("/api/admin/companies/{$company->id}")->assertForbidden();
    }

    public static function nonAdminRoles(): array
    {
        return [
            'job seeker' => ['job_seeker'],
            'company' => ['company'],
        ];
    }

    public function test_admin_can_list_companies_with_counts(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $company = $this->createCompany('PT Contoh Nusantara', 'hrd@contoh.test');
        $job = $this->createJobPosting($company);
        $applicant = User::factory()->create(['role' => 'job_seeker']);
        $applicant->applications()->create(['job_id' => $job->id]);

        $this->getJson('/api/admin/companies')
            ->assertOk()
            ->assertJsonPath('data.data.0.id', $company->id)
            ->assertJsonPath('data.data.0.user.email', 'hrd@contoh.test')
            ->assertJsonPath('data.data.0.jobs_count', 1)
            ->assertJsonPath('data.data.0.applications_count', 1);
    }

    public function test_search_filters_by_company_or_owner(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $this->createCompany('PT Alpha Cemerlang', 'alpha@example.test');
        $this->createCompany('PT Beta Sejahtera', 'beta@example.test');

        $this->getJson('/api/admin/companies?search=alpha')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.company_name', 'PT Alpha Cemerlang');

        $this->getJson('/api/admin/companies?search=beta@example.test')
            ->assertOk()
            ->assertJsonPath('data.total', 1)
            ->assertJsonPath('data.data.0.company_name', 'PT Beta Sejahtera');
    }

    public function test_admin_can_view_company_detail(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $company = $this->createCompany('PT Contoh Nusantara', 'hrd@contoh.test');

        $this->getJson("/api/admin/companies/{$company->id}")
            ->assertOk()
            ->assertJsonPath('data.id', $company->id)
            ->assertJsonPath('data.company_name', 'PT Contoh Nusantara')
            ->assertJsonPath('data.jobs_count', 0);
    }

    public function test_missing_company_returns_404(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));

        $this->getJson('/api/admin/companies/999')->assertNotFound();
    }

    public function test_admin_can_update_company_profile(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $company = $this->createCompany('PT Lama', 'hrd@lama.test');

        $this->putJson("/api/admin/companies/{$company->id}", [
            'company_name' => 'PT Baru Jaya',
            'description' => 'Perusahaan teknologi.',
            'address' => 'Jalan Merdeka No. 1, Madiun',
        ])->assertOk()
            ->assertJsonPath('data.company_name', 'PT Baru Jaya');

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'company_name' => 'PT Baru Jaya',
            'address' => 'Jalan Merdeka No. 1, Madiun',
        ]);
    }

    public function test_company_name_is_required_when_updating(): void
    {
        Sanctum::actingAs(User::factory()->create(['role' => 'admin']));
        $company = $this->createCompany('PT Contoh', 'hrd@contoh.test');

        $this->putJson("/api/admin/companies/{$company->id}", ['company_name' => ''])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['company_name']);

        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'company_name' => 'PT Contoh',
        ]);
    }

    public function test_admin_can_delete_company_with_owner_and_related_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $company = $this->createCompany('PT Contoh', 'hrd@contoh.test');
        $job = $this->createJobPosting($company);
        $applicant = User::factory()->create(['role' => 'job_seeker']);
        $application = $applicant->applications()->create(['job_id' => $job->id]);

        Sanctum::actingAs($admin);

        $this->deleteJson("/api/admin/companies/{$company->id}")
            ->assertOk()
            ->assertJsonPath('message', 'Company, its owner account, and all related data deleted successfully.');

        $this->assertDatabaseMissing('applications', ['id' => $application->id]);
        $this->assertDatabaseMissing('job_postings', ['id' => $job->id]);
        $this->assertDatabaseMissing('companies', ['id' => $company->id]);
        $this->assertDatabaseMissing('users', ['id' => $company->user_id]);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    private function createCompany(string $companyName, string $ownerEmail): Company
    {
        $owner = User::factory()->create([
            'email' => $ownerEmail,
            'role' => 'company',
        ]);

        return $owner->company()->create(['company_name' => $companyName]);
    }

    private function createJobPosting(Company $company): JobPosting
    {
        return $company->jobs()->create([
            'title' => 'Backend Developer',
            'location' => 'Madiun',
            'employment_type' => 'Full-time',
            'description' => 'Membangun aplikasi.',
            'requirements' => 'Menguasai Laravel.',
            'status' => 'open',
        ]);
    }
}
