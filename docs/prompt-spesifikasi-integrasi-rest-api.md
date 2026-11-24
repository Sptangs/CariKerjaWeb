# Prompt — Pertemuan 11: Kriteria Pemilihan Tools & Spesifikasi Integrasi REST API

Jenis prompt: menyusun isi PPT + catatan belajar mandiri untuk Tugas Pertemuan 11 CariKerjaWeb.

```text
PERAN:
Kamu adalah asisten akademik yang ahli dalam analisis kebutuhan integrasi REST API, kriteria pemilihan tools pengujian API, dan penyusunan materi presentasi. Kamu menyusun isi PPT dan ringkasan belajar secara runtut, bukan menulis kode aplikasi.

KONTEKS:
Proyek CariKerjaWeb adalah aplikasi web pencarian lowongan kerja. Aktor: pencari kerja (job seeker), perusahaan/recruiter, admin. Entitas utama: user, perusahaan (company), lowongan (job posting), lamaran (application), kategori, lokasi. Status lowongan: open/closed. Status lamaran: pending/accepted/rejected. Database membatasi satu lamaran per kombinasi pelamar–lowongan. Teknologi proyek: frontend [frontend], backend [backend], database [database], tim [jumlah anggota tim]. Mata kuliah memiliki Sub-CPMK SCPMK0712208: mampu memilih tools yang tepat berdasarkan kebutuhan proyek.

Struktur API yang ada (sumber: routes/api.php) — daftar contoh, bukan wajib dipakai semua. Autentikasi: Sanctum; prefix per role: company, job-seeker, admin. Header terproteksi: Authorization: Bearer {token}; body JSON: Content-Type: application/json.

Contoh endpoint:
- POST /api/auth/login — login
- GET /api/job-seeker/jobs — daftar lowongan (pelamar)
- POST /api/job-seeker/jobs/{job}/applications — kirim lamaran
- GET /api/company/jobs — daftar lowongan (perusahaan)
- PATCH /api/company/applications/{application}/status — terima/tolak lamaran
- GET /api/admin/companies — daftar perusahaan (admin)

TUGAS A — PPT (output yang dikumpulkan):
Susun kerangka dan isi PPT dengan bagian berikut:
1. Penjelasan project CariKerjaWeb: apa aplikasinya, aktor/pengguna, entitas utama, alur singkat (pelamar mencari/melamar lowongan; perusahaan mengelola lowongan & lamaran; admin mengawasi), serta peran integrasi REST API antara frontend dan backend.
2. Spesifikasi kebutuhan integrasi REST API: data/fungsionalitas yang perlu diintegrasikan antarmuka dan backend (autentikasi, CRUD lowongan, lamaran, profil, dsb.) berdasarkan entitas di atas.
3. Daftar endpoint sebagai contoh (bukan seluruh API): ambil 5–8 endpoint representatif dari struktur API di KONTEKS; setiap baris memuat endpoint, method, header, dan parameter yang relevan.
4. Tabel perbandingan tools: bandingkan minimal 3 tools pengujian/integrasi API (mis. Postman, Thunder Client, Insomnia).
5. Kriteria pemilihan tools — wajib memuat:
   a. tools yang dipilih (1 utama + 1 alternatif);
   b. kebutuhan proyek yang mendasari pemilihan;
   c. kelebihan dan keterbatasan tiap tools yang dibandingkan;
   d. alasan mengapa tools terpilih lebih sesuai dibanding alternatifnya.
6. Rekomendasi tools beserta argumentasinya, selaras kebutuhan proyek dan Sub-CPMK SCPMK0712208.

TUGAS B — Belajar Mandiri (BM): catatan ringkasan, bukan slide wajib:
Baca materi HTTP dan REST pada MDN Web Docs (https://developer.mozilla.org), lalu tulis ringkasan yang menjawab:
- Apa yang dimaksud dengan REST API?
- Apa fungsi HTTP method GET, POST, PUT, PATCH, dan DELETE?
- Apa perbedaan endpoint, header, dan parameter?
- Apa fungsi status code HTTP?
- Mengapa JSON banyak digunakan sebagai format pertukaran data?
- Ringkasan: konsep REST API; fungsi HTTP method; struktur request dan response; contoh komunikasi antara frontend dan backend (sketsa/alur singkat, bukan kode aplikasi).

FORMAT OUTPUT:
- Bahasa Indonesia.
- Bagian A (PPT), 10–14 slide, poin bullet ringkas:
  judul; penjelasan project CariKerjaWeb; tujuan integrasi; spesifikasi kebutuhan integrasi; contoh endpoint (tabel); tabel perbandingan tools; kriteria pemilihan (kebutuhan proyek, kelebihan/keterbatasan, alasan); rekomendasi + argumentasi; daftar pustaka (MDN dsb.); penutup.
- Tabel contoh endpoint WAJIB berkolom: No, Endpoint, Method, Header, Parameter, Fungsi (5–8 baris, cukup contoh representatif — jangan menampilkan seluruh API).
- Tabel perbandingan tools: kolom Tools, Kelebihan, Keterbatasan, Kesesuaian untuk CariKerjaWeb.
- Path endpoint harus berasal dari struktur API di KONTEKS; jangan mengarang path baru.
- Bagian B: ringkasan terstruktur per pertanyaan (bukan slide), maksimum ±2 halaman setara teks.

ATURAN:
- Jangan mengarang fitur di luar deskripsi proyek di atas.
- Endpoint, nama field, dan status harus konsisten dengan konteks (open/closed; pending/accepted/rejected).
- Jangan menulis kode aplikasi, migrasi, atau controller; fokus pada spesifikasi integrasi, pemilihan tools, dan presentasi.
- Jangan mengubah angka/istilah Sub-CPMK SCPMK0712208.
- Jika merujuk MDN, cukup sebut judul materi/URL umum; jangan mengarang kutipan panjang.
- Hormati placeholder [frontend], [backend], [database], [jumlah anggota tim]; jangan isi sendiri jika belum diberikan.

KRITERIA SELESAI:
- PPT memuat: penjelasan project CariKerjaWeb, spesifikasi integrasi, contoh endpoint (5–8) + method/header/parameter, tabel perbandingan tools, rekomendasi + argumentasi.
- Kriteria pemilihan memuat: tools dipilih, kebutuhan proyek, kelebihan & keterbatasan, alasan lebih sesuai dari alternatif.
- Kolom tabel endpoint persis: No, Endpoint, Method, Header, Parameter, Fungsi; hanya contoh representatif, bukan seluruh API.
- Minimal 3 tools dibandingkan; 1 rekomendasi utama berdalih.
- Bagian BM menjawab seluruh pertanyaan hal yang perlu dipahami + catatan ringkasan yang diminta.
- Tidak ada fitur fiktif; endpoint cocok dengan struktur API proyek; istilah entitas/status konsisten; siap dipindah ke PPT/catatan.
```

## Placeholder yang harus diisi

- `[frontend]`
- `[backend]`
- `[database]`
- `[jumlah anggota tim]`

## Saran perbaikan opsional

Jika dosen membatasi jumlah tools atau melarang tools tertentu, tambahkan ke bagian ATURAN agar pemilihan tools lebih presisi.
