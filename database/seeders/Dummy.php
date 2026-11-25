<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Dummy extends Seeder
{
    public function run(): void
    {
        $now = now();
        $password = Hash::make('password');
        $cities = ['Madiun', 'Surabaya', 'Jakarta', 'Malang', 'Yogyakarta'];
        $types = ['full_time', 'part_time', 'contract', 'internship'];
        $titles = ['Staff Administrasi', 'Web Developer', 'Customer Service',
            'Akuntan', 'Desainer Grafis', 'Sales Executive', 'Operator Produksi'];

        $companyIds = [];

        for ($i = 1; $i <= 5; $i++) {
            $email = "company$i@example.com";

            DB::table('users')->updateOrInsert(
                ['email' => $email],
                [
                    'name' => "Company Dummy $i",
                    'email_verified_at' => $now,
                    'password' => $password,
                    'role' => 'company',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $userId = DB::table('users')->where('email', $email)->value('id');

            DB::table('companies')->updateOrInsert(
                ['user_id' => $userId],
                [
                    'company_name' => "PT Contoh Sejahtera $i",
                    'description' => "Perusahaan dummy nomor $i yang bergerak di berbagai bidang.",
                    'address' => "Jl. Contoh No. $i, ".$cities[$i % count($cities)],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );

            $companyIds[] = DB::table('companies')->where('user_id', $userId)->value('id');
        }

        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->updateOrInsert(
                ['email' => "dummy.seeker$i@example.com"],
                [
                    'name' => "Pencari Kerja $i",
                    'email_verified_at' => $now,
                    'password' => $password,
                    'role' => 'job_seeker',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        for ($i = 1; $i <= 20; $i++) {
            $min = (($i - 1) % 6 + 3) * 1_000_000;

            DB::table('job_postings')->updateOrInsert(
                [
                    'company_id' => $companyIds[($i - 1) % count($companyIds)],
                    'title' => $titles[($i - 1) % count($titles)]." #$i",
                ],
                [
                    'location' => $cities[($i - 1) % count($cities)],
                    'employment_type' => $types[($i - 1) % count($types)],
                    'salary_min' => $min,
                    'salary_max' => $min + (($i - 1) % 4 + 2) * 1_000_000,
                    'description' => "Deskripsi pekerjaan dummy nomor $i.",
                    'requirements' => 'Minimal SMA/SMK, jujur, mau belajar, komunikatif.',
                    'status' => $i % 5 === 0 ? 'closed' : 'open',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }
}
