<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobSeekerApplicationTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_seeker_can_apply_and_view_their_application_history(): void
    {
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        $job = $this->createJobPosting();

        $this->actingAs($jobSeeker)
            ->post(route('job-seeker.lowongan.apply', $job))
            ->assertRedirect(route('job-seeker.riwayat'))
            ->assertSessionHas('status', 'Lamaran berhasil dikirim.');

        $this->assertDatabaseHas('applications', [
            'job_id' => $job->id,
            'user_id' => $jobSeeker->id,
            'status' => 'pending',
        ]);

        $application = $jobSeeker->applications()->firstOrFail();

        $this->get(route('job-seeker.riwayat'))
            ->assertSee('Backend Developer')
            ->assertSee('PT Contoh Nusantara')
            ->assertSee('Madiun')
            ->assertSee('Menunggu')
            ->assertSee($application->created_at->format('d/m/Y H:i'))
            ->assertSee('Lamaran berhasil dikirim.');
    }

    public function test_job_seeker_cannot_apply_to_a_closed_job(): void
    {
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        $job = $this->createJobPosting(status: 'closed');

        $this->actingAs($jobSeeker)
            ->post(route('job-seeker.lowongan.apply', $job))
            ->assertRedirect(route('job-seeker.lowongan.detail', $job))
            ->assertSessionHas('status', 'Lowongan sudah ditutup dan tidak dapat dilamar.');

        $this->assertDatabaseMissing('applications', [
            'job_id' => $job->id,
            'user_id' => $jobSeeker->id,
        ]);
    }

    public function test_duplicate_application_is_not_created(): void
    {
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        $job = $this->createJobPosting();
        $jobSeeker->applications()->create(['job_id' => $job->id]);

        $this->actingAs($jobSeeker)
            ->post(route('job-seeker.lowongan.apply', $job))
            ->assertRedirect(route('job-seeker.riwayat'))
            ->assertSessionHas('status', 'Kamu sudah melamar lowongan ini.');

        $this->assertSame(
            1,
            $jobSeeker->applications()->where('job_id', $job->id)->count()
        );
    }

    public function test_detail_shows_applied_state_without_an_apply_button(): void
    {
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        $job = $this->createJobPosting();
        $jobSeeker->applications()->create(['job_id' => $job->id]);

        $this->actingAs($jobSeeker)
            ->get(route('job-seeker.lowongan.detail', $job))
            ->assertSee('Sudah Melamar')
            ->assertDontSee('Lamar Sekarang');
    }

    public function test_history_only_shows_the_authenticated_users_applications(): void
    {
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);
        $otherJobSeeker = User::factory()->create(['role' => 'job_seeker']);
        $ownJob = $this->createJobPosting(title: 'Backend Developer');
        $otherJob = $this->createJobPosting(
            title: 'UI/UX Designer',
            companyName: 'PT Perusahaan Lain'
        );

        $jobSeeker->applications()->create(['job_id' => $ownJob->id]);
        $otherJobSeeker->applications()->create(['job_id' => $otherJob->id]);

        $this->actingAs($jobSeeker)
            ->get(route('job-seeker.riwayat'))
            ->assertSee('Backend Developer')
            ->assertDontSee('UI/UX Designer')
            ->assertDontSee('PT Perusahaan Lain');
    }

    public function test_only_authenticated_job_seekers_can_submit_applications(): void
    {
        $job = $this->createJobPosting();

        $this->post(route('job-seeker.lowongan.apply', $job))
            ->assertRedirect(route('login'));

        $companyUser = User::factory()->create(['role' => 'company']);

        $this->actingAs($companyUser)
            ->post(route('job-seeker.lowongan.apply', $job))
            ->assertForbidden();

        $this->assertDatabaseMissing('applications', ['job_id' => $job->id]);
    }

    private function createJobPosting(
        string $status = 'open',
        string $title = 'Backend Developer',
        string $companyName = 'PT Contoh Nusantara'
    ): JobPosting {
        $companyUser = User::factory()->create(['role' => 'company']);
        $company = $companyUser->company()->create([
            'company_name' => $companyName,
        ]);

        return $company->jobs()->create([
            'title' => $title,
            'location' => 'Madiun',
            'employment_type' => 'Full-time',
            'description' => 'Membangun aplikasi.',
            'requirements' => 'Menguasai Laravel.',
            'status' => $status,
        ]);
    }
}
