@extends('layouts.company')

@section('title', 'Lowongan Saya')

@section('dashboard-content')
    <section>
        <div class="mb-5 flex items-center justify-between">
            <div>
                <p class="mt-1 text-xs font-bold text-blue-500">KELOLA REKRUTMEN</p>
                <h1 class="text-3xl font-bold text-slate-900">Lowongan Saya</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola posisi, status, dan pelamar dalam satu tempat.</p>
            </div>
            <a href="{{ route('company.lowongan.create') }}" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                Buat Lowongan
            </a>
        </div>

        @if(session('success'))
            <div>
                {{ session('success') }}
            </div>
        @endif

        @if($jobPostings->isEmpty())
            <div class="rounded-lg border-2 border-dashed border-slate-200 bg-slate-50 p-12 text-center">
                <h3 class="text-lg font-semibold text-slate-700">Belum ada lowongan</h3>
                <p class="mt-2 text-sm text-slate-500">Buat lowongan pertama Anda untuk mulai mengumpulkan kandidat terbaik.</p>
                <a href="{{ route('company.lowongan.create') }}" class="mt-4 inline-block rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                    Buat Lowongan
                </a>
            </div>
        @else
            <div class="rounded-lg border border-slate-200 bg-white">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                            <th class="px-4 py-3">Judul</th>
                            <th class="px-4 py-3">Lokasi</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Pelamar</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jobPostings as $job)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $job->title }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $job->location }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $job->employment_type }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $job->applications->count() }}</td>
                            <td class="px-4 py-3">
                                @if($job->status === 'open')
                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Tersedia</span>
                                @else
                                    <span class="rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-600">Ditutup</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('company.lowongan.pelamar', $job) }}" class="rounded bg-100 border border-blue-200 px-3 py-2 font-semibold text-slate-800 hover:underline text-xs font-semibold">Lihat Pelamar</a>
                                    <a href="{{ route('company.lowongan.edit', $job) }}" class="rounded bg-200 border border-slate-300 px-3 py-2 font-semibold text-slate-800 hover:underline text-xs font-semibold">Edit</a>
                                    @if($job->status === 'open')
                                        <form method="POST" action="{{ route('company.lowongan.tutup', $job) }}" onsubmit="return confirm('Tutup lowongan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="rounded bg-red-100 px-3 py-2 text-red-600 hover:underline text-xs font-semibold">Tutup</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection