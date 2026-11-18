<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $seekers = [
            'Aditya Pratama', 'Ayu Lestari', 'Bagas Saputra', 'Citra Maharani',
            'Dimas Kurniawan', 'Dewi Anggraini', 'Eko Setiawan', 'Fitri Handayani',
            'Galih Ramadhan', 'Hana Putri', 'Ilham Maulana', 'Indah Permata',
            'Joko Susanto', 'Kartika Sari', 'Lukman Hakim', 'Maya Safitri',
            'Naufal Hidayat', 'Nadia Amelia', 'Rizky Firmansyah', 'Salsa Febriani',
        ];

        $companies = [
            [
                'name' => 'PT Teknologi Nusantara',
                'description' => 'Perusahaan pengembangan perangkat lunak dan layanan digital.',
                'address' => 'Jakarta',
            ],
            [
                'name' => 'CV Karya Digital',
                'description' => 'Agensi digital yang membantu bisnis bertumbuh secara online.',
                'address' => 'Bandung',
            ],
            [
                'name' => 'PT Maju Bersama',
                'description' => 'Perusahaan jasa dan operasional dengan jaringan nasional.',
                'address' => 'Surabaya',
            ],
            [
                'name' => 'PT Solusi Cerdas',
                'description' => 'Penyedia solusi teknologi, analitik, dan konsultasi bisnis.',
                'address' => 'Yogyakarta',
            ],
            [
                'name' => 'PT Sejahtera Abadi',
                'description' => 'Perusahaan layanan pelanggan dan distribusi.',
                'address' => 'Madiun',
            ],
        ];

        $jobTemplates = [
            [
                'title' => 'Backend Developer',
                'employment_type' => 'Full-time',
                'salary_min' => 6000000,
                'salary_max' => 10000000,
                'description' => 'Mengembangkan dan memelihara API serta layanan backend.',
                'requirements' => 'Menguasai PHP atau Node.js, REST API, dan basis data relasional.',
            ],
            [
                'title' => 'Frontend Developer',
                'employment_type' => 'Full-time',
                'salary_min' => 5500000,
                'salary_max' => 9500000,
                'description' => 'Membangun antarmuka web yang responsif dan mudah digunakan.',
                'requirements' => 'Menguasai HTML, CSS, JavaScript, dan salah satu framework frontend.',
            ],
            [
                'title' => 'Full Stack Developer',
                'employment_type' => 'Full-time',
                'salary_min' => 7000000,
                'salary_max' => 12000000,
                'description' => 'Mengembangkan fitur aplikasi dari sisi frontend hingga backend.',
                'requirements' => 'Memahami frontend, backend, REST API, dan Git.',
            ],
            [
                'title' => 'UI/UX Designer',
                'employment_type' => 'Full-time',
                'salary_min' => 5000000,
                'salary_max' => 8500000,
                'description' => 'Merancang alur pengguna dan tampilan produk digital.',
                'requirements' => 'Memiliki portofolio desain serta menguasai Figma dan dasar UX.',
            ],
            [
                'title' => 'Data Analyst',
                'employment_type' => 'Full-time',
                'salary_min' => 6000000,
                'salary_max' => 10000000,
                'description' => 'Mengolah data dan menyajikan insight untuk mendukung keputusan bisnis.',
                'requirements' => 'Menguasai SQL, spreadsheet, dan visualisasi data.',
            ],
            [
                'title' => 'Digital Marketing Specialist',
                'employment_type' => 'Full-time',
                'salary_min' => 4500000,
                'salary_max' => 8000000,
                'description' => 'Merencanakan dan menjalankan kampanye pemasaran digital.',
                'requirements' => 'Memahami SEO, media sosial, dan analisis performa kampanye.',
            ],
            [
                'title' => 'HR Generalist',
                'employment_type' => 'Full-time',
                'salary_min' => 5000000,
                'salary_max' => 8500000,
                'description' => 'Mendukung proses rekrutmen dan administrasi sumber daya manusia.',
                'requirements' => 'Memahami administrasi HR, komunikasi, dan proses rekrutmen.',
            ],
            [
                'title' => 'Customer Service Representative',
                'employment_type' => 'Kontrak',
                'salary_min' => 4000000,
                'salary_max' => 6500000,
                'description' => 'Membantu pelanggan melalui kanal komunikasi perusahaan.',
                'requirements' => 'Komunikatif, teliti, dan mampu menangani pertanyaan pelanggan.',
            ],
            [
                'title' => 'Accounting Staff',
                'employment_type' => 'Full-time',
                'salary_min' => 4500000,
                'salary_max' => 7500000,
                'description' => 'Mendukung pencatatan transaksi dan penyusunan laporan keuangan.',
                'requirements' => 'Memahami akuntansi dasar dan mampu menggunakan spreadsheet.',
            ],
            [
                'title' => 'Project Coordinator',
                'employment_type' => 'Kontrak',
                'salary_min' => 5500000,
                'salary_max' => 9000000,
                'description' => 'Mengkoordinasikan jadwal, komunikasi, dan progres proyek.',
                'requirements' => 'Terorganisir, komunikatif, dan terbiasa mengelola pekerjaan tim.',
            ],
        ];

        DB::transaction(function () use ($seekers, $companies, $jobTemplates): void {
            $password = Hash::make('password');
            $educationLevels = [
                'S1 Teknik Informatika',
                'S1 Sistem Informasi',
                'D3 Manajemen Informatika',
                'S1 Manajemen',
                'SMK Rekayasa Perangkat Lunak',
            ];
            $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Madiun'];

            foreach ($seekers as $index => $name) {
                $number = $index + 1;
                $user = User::updateOrCreate(
                    ['email' => sprintf('demo.seeker%02d@example.test', $number)],
                    [
                        'name' => $name,
                        'password' => $password,
                        'role' => 'job_seeker',
                    ]
                );

                $user->jobSeekerProfile()->updateOrCreate([], [
                    'phone' => sprintf('0812900%04d', $number),
                    'address' => $cities[$index % count($cities)],
                    'education' => $educationLevels[$index % count($educationLevels)],
                ]);
            }

            foreach ($companies as $companyIndex => $companyData) {
                $number = $companyIndex + 1;
                $user = User::updateOrCreate(
                    ['email' => sprintf('demo.company%02d@example.test', $number)],
                    [
                        'name' => $companyData['name'],
                        'password' => $password,
                        'role' => 'company',
                    ]
                );

                /** @var Company $company */
                $company = $user->company()->updateOrCreate([], [
                    'company_name' => $companyData['name'],
                    'description' => $companyData['description'],
                    'address' => $companyData['address'],
                ]);

                foreach ($jobTemplates as $jobIndex => $job) {
                    $company->jobs()->firstOrCreate(
                        ['title' => $job['title']],
                        [
                            'location' => $companyData['address'],
                            'employment_type' => $job['employment_type'],
                            'salary_min' => $job['salary_min'],
                            'salary_max' => $job['salary_max'],
                            'description' => $job['description'],
                            'requirements' => $job['requirements'],
                            'status' => $jobIndex === 9 ? 'closed' : 'open',
                        ]
                    );
                }
            }
        });

        $this->command?->info(
            'Demo data siap: 20 akun job seeker, 5 akun perusahaan, dan 50 lowongan.'
        );
    }
}
