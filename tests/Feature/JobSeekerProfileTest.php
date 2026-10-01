<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JobSeekerProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_seeker_can_view_profile(): void
    {
        $user = User::factory()->create(['role' => 'job_seeker']);

        $this->actingAs($user)
            ->get(route('job-seeker.profile'))
            ->assertOk()
            ->assertSee('Profil Saya');
    }

    public function test_job_seeker_can_update_profile_and_upload_cv(): void
    {
        Storage::fake('local');
        $user = User::factory()->create(['role' => 'job_seeker']);

        $this->actingAs($user)
            ->put(route('job-seeker.profile.update'), [
                'name' => 'Dewi Lestari',
                'email' => $user->email,
                'phone' => '081234567890',
                'address' => 'Bandung',
                'education' => 'S1 Informatika',
                'cv' => UploadedFile::fake()->create('resume.pdf', 100, 'application/pdf'),
            ])
            ->assertRedirect(route('job-seeker.profile'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Dewi Lestari',
        ]);

        $profile = $user->jobSeekerProfile()->firstOrFail();
        $this->assertSame('081234567890', $profile->phone);
        $this->assertSame('S1 Informatika', $profile->education);
        $this->assertTrue(Storage::disk('local')->exists($profile->cv_path));
    }

    public function test_other_roles_cannot_view_job_seeker_profile(): void
    {
        $companyUser = User::factory()->create(['role' => 'company']);

        $this->actingAs($companyUser)
            ->get(route('job-seeker.profile'))
            ->assertForbidden();
    }
}
