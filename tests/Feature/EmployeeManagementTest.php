<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_can_create_an_employee_for_its_own_company(): void
    {
        $user = User::factory()->create(['role' => 'company']);
        $company = $user->company()->create(['company_name' => 'PT Contoh Nusantara']);

        $this->actingAs($user)
            ->post(route('company.employees.store'), [
                'employee_name' => 'Septian Angga S',
                'position' => 'Software Dev',
                'department' => 'Developer',
                'hire_date' => '2026-10-22',
                'employment_status' => 'active',
            ])
            ->assertRedirect(route('company.employees.index'));

        $this->assertDatabaseHas('employees', [
            'company_id' => $company->id,
            'employee_name' => 'Septian Angga S',
        ]);
    }
}
