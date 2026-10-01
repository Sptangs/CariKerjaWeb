<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CariKerjaSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $septian = $this->createJobSeeker('Septian', 'seeker@example.com', [
            'phone' => '081234567890',
            'address' => 'Madiun, Jawa Timur',
            'education' => 'D4 Teknologi Rekayasa Perangkat Lunak',
        ]);

        $budi = $this->createJobSeeker('Budi Santoso', 'seeker2@example.com', [
            'phone' => '081298765432',
            'address' => 'Ngawi, Jawa Timur',
            'education' => 'S1 Teknik Informatika',
        ]);

        $siti = $this->createJobSeeker('Siti Aminah', 'seeker3@example.com', [
            'phone' => '081355577788',
            'address' => 'Surabaya, Jawa Timur',
            'education' => 'D3 Sistem Informasi',
        ]);

        $companyUser = User::updateOrCreate(
            ['email' => 'company@example.com'],
            [
                'name' => 'PT Teknologi Maju',
                'password' => Hash::make('password'),
                'role' => 'company',
            ]
        );

        $company = $companyUser->company()->updateOrCreate([], [
            'company_name' => 'PT Teknologi Maju',
            'description' => 'Perusahaan software house yang fokus pada pengembangan aplikasi web.',
            'address' => 'Madiun, Jawa Timur',
        ]);

        $jobs = [];

        $jobs['backend'] = $company->jobs()->updateOrCreate(
            ['title' => 'Backend Developer'],
            [
                'location' => 'Madiun',
                'employment_type' => 'Full-time',
                'salary_min' => 5000000,
                'salary_max' => 8000000,
                'description' => 'Membangun dan merawat REST API serta logika bisnis aplikasi web.',
                'requirements' => "Menguasai PHP dan Laravel\nPaham MySQL dan Eloquent\nTerbiasa memakai Git",
                'status' => 'open',
            ]
        );

        $jobs['frontend'] = $company->jobs()->updateOrCreate(
            ['title' => 'Frontend Developer'],
            [
                'location' => 'Surabaya',
                'employment_type' => 'Full-time',
                'salary_min' => 5000000,
                'salary_max' => 7500000,
                'description' => 'Membuat antarmuka web yang responsif dan mudah digunakan.',
                'requirements' => "Menguasai HTML, CSS, dan JavaScript\nPaham desain responsif\nMampu membaca desain Figma",
                'status' => 'open',
            ]
        );

        $jobs['fullstack'] = $company->jobs()->updateOrCreate(
            ['title' => 'Full Stack Developer'],
            [
                'location' => 'Madiun',
                'employment_type' => 'Kontrak',
                'salary_min' => 6000000,
                'salary_max' => 10000000,
                'description' => 'Mengerjakan fitur dari database sampai tampilan.',
                'requirements' => "Menguasai Laravel dan Blade\nPaham MySQL\nMampu bekerja dalam tim",
                'status' => 'open',
            ]
        );

        $jobs['designer'] = $company->jobs()->updateOrCreate(
            ['title' => 'UI/UX Designer'],
            [
                'location' => 'Madiun',
                'employment_type' => 'Magang',
                'salary_min' => null,
                'salary_max' => null,
                'description' => 'Merancang desain antarmuka dan alur pengguna aplikasi.',
                'requirements' => "Menguasai Figma\nPaham dasar UX",
                'status' => 'closed',
            ]
        );

        $this->apply(
            $jobs['backend'],
            $septian,
            'pending',
            'Saya tertarik pada posisi Backend Developer.'
        );

        $this->apply(
            $jobs['frontend'],
            $septian,
            'accepted',
            'Saya terbiasa membuat antarmuka dari desain Figma.'
        );

        $this->apply(
            $jobs['backend'],
            $budi,
            'rejected',
            'Saya punya pengalaman membangun API dengan Laravel.'
        );

        $this->apply(
            $jobs['fullstack'],
            $siti,
            'pending',
            'Saya ingin berkembang sebagai full stack developer.'
        );
    }

    private function createJobSeeker(
        string $name,
        string $email,
        array $profile
    ): User {
        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make('password'),
                'role' => 'job_seeker',
            ]
        );

        $user->jobSeekerProfile()->updateOrCreate([], $profile);

        return $user;
    }

    private function apply(
        JobPosting $job,
        User $user,
        string $status,
        string $coverLetter
    ): void {
        if ($job->applications()->where('user_id', $user->id)->exists()) {
            return;
        }

        $application = new Application([
            'cover_letter' => $coverLetter,
        ]);

        $application->job_id = $job->id;
        $application->user_id = $user->id;
        $application->status = $status;
        $application->save();
    }
}
