<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_can_view_profile(): void
    {
        $user = User::factory()->create(['role' => 'company']);
        $user->company()->create(['company_name' => 'PT Contoh Nusantara']);

        $this->actingAs($user)
            ->get(route('company.profile'))
            ->assertOk()
            ->assertSee('Profil Perusahaan')
            ->assertSee('PT Contoh Nusantara');
    }

    public function test_company_can_update_account_and_company_profile(): void
    {
        $user = User::factory()->create(['role' => 'company']);
        $user->company()->create(['company_name' => 'Nama Lama']);

        $this->actingAs($user)
            ->put(route('company.profile.update'), [
                'name' => 'Rina Putri',
                'email' => $user->email,
                'company_name' => 'PT Kerja Bersama',
                'description' => 'Perusahaan teknologi.',
                'address' => 'Jakarta',
            ])
            ->assertRedirect(route('company.profile'));

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Rina Putri',
        ]);
        $this->assertDatabaseHas('companies', [
            'user_id' => $user->id,
            'company_name' => 'PT Kerja Bersama',
            'address' => 'Jakarta',
        ]);
    }

    public function test_job_seeker_cannot_view_company_profile(): void
    {
        $jobSeeker = User::factory()->create(['role' => 'job_seeker']);

        $this->actingAs($jobSeeker)
            ->get(route('company.profile'))
            ->assertForbidden();
    }
}
