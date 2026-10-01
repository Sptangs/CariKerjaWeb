
@extends('layouts.job-seeker')

@section('title', 'Riwayat Lamaran')

@section('dashboard-content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">
            Riwayat Lamaran
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Pantau status lamaran pekerjaan yang telah kamu kirim.
        </p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="py-10 text-center">
            <div class="mb-3 text-4xl">📋</div>

            <h2 class="text-lg font-semibold text-slate-800">
                Belum Ada Lamaran
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                Lamaran pekerjaan yang kamu kirim akan muncul di halaman ini.
            </p>

<a
    href="{{ route('job-seeker.lowongan') }}"
    class="mt-5 inline-flex rounded-xl bg-indigo-600 px-5 py-2.5
           text-sm font-semibold text-white transition
           hover:bg-indigo-700"
>
    Cari Lowongan
</a>
        </div>
    </div>

@endsection