<?php

namespace Tests\Feature;

use Database\Seeders\CariKerjaSeeder;
use Database\Seeders\Dummy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DummySeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_dummy_seeder_is_safe_to_run_after_demo_seeder_and_more_than_once(): void
    {
        $this->seed(CariKerjaSeeder::class);
        $this->seed(Dummy::class);
        $this->seed(Dummy::class);

        $this->assertDatabaseHas('users', [
            'email' => 'seeker2@example.com',
            'name' => 'Budi Santoso',
        ]);
        $this->assertDatabaseCount('companies', 6);
        $this->assertDatabaseCount('job_postings', 24);
        $this->assertDatabaseCount('users', 20);
    }
}
