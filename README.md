# CariKerja

**CariKerja** adalah website pencarian kerja berbasis web yang membantu **pencari kerja** menemukan lowongan, melihat detail pekerjaan, mengirim lamaran menggunakan CV yang tersimpan di profil, serta memantau riwayat lamaran.

Website ini dikembangkan menggunakan **Laravel** dengan konsep server-side rendering menggunakan **Blade** dan database relasional untuk mengelola data pengguna, perusahaan, lowongan, profil pencari kerja, dan lamaran.

---

## ✨ Fitur Utama

### 👤 Pencari Kerja

Pencari kerja dapat:

* Membuat dan mengelola profil.
* Mengisi informasi pendidikan dan kontak.
* Mengunggah CV dalam format PDF, DOC, atau DOCX.
* Melihat daftar lowongan pekerjaan.
* Mencari lowongan berdasarkan:

  * Kata kunci
  * Lokasi
* Melihat detail lowongan.
* Melamar pekerjaan menggunakan CV yang tersimpan di profil.
* Menambahkan alasan mengapa cocok dengan pekerjaan.
* Mencegah pengiriman lamaran ganda pada lowongan yang sama.
* Melihat riwayat lamaran.
* Melihat status lamaran.

### 🏢 Perusahaan

Perusahaan dapat mengelola kebutuhan rekrutmen dan lowongan pekerjaan, termasuk data lowongan dan lamaran dari pencari kerja.

### 🔐 Autentikasi dan Role

Sistem menggunakan autentikasi dan pembagian role untuk membatasi akses pengguna sesuai kebutuhan aplikasi.

Role yang digunakan dalam aplikasi dapat mencakup:

* **Job Seeker** — mencari dan melamar pekerjaan.
* **Company** — mengelola lowongan dan proses lamaran.
* **Admin** — mengelola sistem.

---

## 🔄 Alur Pencari Kerja

Alur utama pencari kerja pada website:

```text
Login
  │
  ▼
Dashboard
  │
  ├── Profil
  │     ├── Data diri
  │     ├── Pendidikan
  │     └── CV
  │
  ├── Lowongan
  │     │
  │     ▼
  │   Detail Lowongan
  │     │
  │     ▼
  │   Lamar Sekarang
  │     │
  │     ▼
  │   Alasan Melamar
  │     │
  │     ▼
  │   Kirim Lamaran
  │     │
  │     ▼
  │   Riwayat Lamaran
  │
  └── Riwayat Lamaran
```

CV tidak perlu diunggah kembali ketika melamar. Sistem menggunakan CV yang sudah tersimpan pada profil pencari kerja.

---

## 🛠️ Teknologi yang Digunakan

### Backend

* PHP 8.3+
* Laravel 13
* Laravel Blade
* Eloquent ORM

### Frontend

* Blade Template
* Tailwind CSS
* Vite
* JavaScript

### Database

* MySQL

### Development Tools

* Composer
* NPM
* Git
* GitHub
* Laragon

---

## 📁 Struktur Halaman Job Seeker

```text
resources/views/
└── job-seeker/
    ├── dashboard.blade.php
    ├── lowongan.blade.php
    ├── detail-lowongan.blade.php
    ├── lamaran.blade.php
    ├── riwayat.blade.php
    └── profile.blade.php
```

Layout utama:

```text
resources/views/layouts/
└── job-seeker.blade.php
```

---

## 🗄️ Struktur Data Utama

Beberapa tabel utama yang digunakan:

```text
users
   │
   ├── job_seeker_profiles
   │
   └── applications
          │
          ▼
     job_postings
          │
          ▼
      companies
```

### `users`

Menyimpan data akun pengguna.

### `job_seeker_profiles`

Menyimpan informasi tambahan pencari kerja seperti:

* Nomor telepon
* Alamat
* Pendidikan
* Lokasi CV

### `companies`

Menyimpan informasi perusahaan.

### `job_postings`

Menyimpan informasi lowongan seperti:

* Judul pekerjaan
* Lokasi
* Tipe pekerjaan
* Gaji
* Deskripsi
* Persyaratan
* Status lowongan

### `applications`

Menyimpan data lamaran:

* Lowongan
* Pencari kerja
* Cover letter / alasan melamar
* Status lamaran
* Waktu pengajuan

Status lamaran:

```text
pending
accepted
rejected
```

Satu pengguna tidak dapat melamar lowongan yang sama lebih dari satu kali.

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/CariKerja.git
cd CariKerja
```

> Ganti URL repository sesuai repository GitHub yang digunakan.

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Install Dependency Frontend

```bash
npm install
```

### 4. Buat File Environment

Salin file `.env.example` menjadi `.env`.

```bash
cp .env.example .env
```

Untuk Windows jika menggunakan Command Prompt:

```cmd
copy .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Konfigurasi Database

Buat database MySQL, kemudian sesuaikan konfigurasi pada `.env`.

Contoh:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=carikerja
DB_USERNAME=root
DB_PASSWORD=
```

### 7. Jalankan Migration

```bash
php artisan migrate
```

Jika project menyediakan seeder:

```bash
php artisan db:seed
```

Atau:

```bash
php artisan migrate --seed
```

### 8. Jalankan Vite

Untuk development:

```bash
npm run dev
```

### 9. Jalankan Laravel

Pada terminal lain:

```bash
php artisan serve
```

Website dapat diakses melalui:

```text
http://localhost:8000
```

---

## 🔧 Perintah Development

Menjalankan Laravel:

```bash
php artisan serve
```

Menjalankan Vite:

```bash
npm run dev
```

Build frontend:

```bash
npm run build
```

Melihat daftar route:

```bash
php artisan route:list
```

Membersihkan cache:

```bash
php artisan optimize:clear
```

Menjalankan migration:

```bash
php artisan migrate
```

Rollback migration:

```bash
php artisan migrate:rollback
```

---

## 🔒 Keamanan

Beberapa mekanisme keamanan yang digunakan:

* Authentication untuk pengguna.
* Role-based authorization.
* CSRF protection pada form.
* Validasi input menggunakan Laravel Validation.
* Pembatasan akses berdasarkan role.
* Pencegahan lamaran ganda melalui unique constraint database.
* CV disimpan pada storage private dan tidak langsung diekspos sebagai file publik.
* Password pengguna dikelola menggunakan mekanisme hashing Laravel.

---

## 📄 CV Pencari Kerja

CV disimpan melalui storage Laravel dan path file disimpan pada:

```text
job_seeker_profiles.cv_path
```

CV dapat:

* Diunggah melalui halaman profil.
* Diganti dengan CV baru.
* Diunduh melalui halaman profil.
* Dihapus dari profil.

Ketika pengguna melamar pekerjaan, sistem menggunakan CV yang sudah tersimpan pada profil sehingga pengguna tidak perlu mengunggah CV kembali.

---

## 🎯 Tujuan Project

CariKerja dibuat sebagai aplikasi pencarian dan rekrutmen pekerjaan sederhana yang mempertemukan pencari kerja dengan perusahaan dalam satu platform.

Project ini juga digunakan sebagai media pembelajaran dalam penerapan:

* Laravel
* MVC Architecture
* Blade Template
* Routing
* Middleware
* Authentication
* Authorization
* Eloquent ORM
* Database Relationship
* Migration
* Form Validation
* File Upload
* RESTful Route
* Git dan GitHub

---

## 👨‍💻 Pengembang

**Septian Angga Saputra**

Teknologi Rekayasa Perangkat Lunak
Politeknik Negeri Madiun

---

## 📌 Status Project

**Development**

Project masih dalam tahap pengembangan dan fitur dapat mengalami perubahan sesuai kebutuhan pengembangan aplikasi.
