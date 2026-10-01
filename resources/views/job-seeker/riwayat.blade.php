
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

    @if (session('status'))
        <div role="status" class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    @forelse ($applications as $application)
        <article class="mb-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        {{ $application->job->title }}
                    </h2>
                    <p class="mt-1 text-sm font-medium text-slate-600">
                        {{ $application->job->company->company_name ?? 'Perusahaan' }}
                    </p>
                </div>

                <span class="inline-flex w-fit rounded-lg px-3 py-1.5 text-sm font-semibold
                    {{ $application->status === 'accepted' ? 'bg-emerald-100 text-emerald-800' : ($application->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-amber-100 text-amber-800') }}">
                    {{ match ($application->status) {
                        'pending' => 'Menunggu',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                        default => ucfirst($application->status),
                    } }}
                </span>
            </div>

            <div class="mt-4 flex flex-col gap-2 border-t border-slate-100 pt-4 text-sm text-slate-500 sm:flex-row sm:gap-6">
                <p>Lokasi: <span class="font-medium text-slate-700">{{ $application->job->location }}</span></p>
                <p>Tanggal lamaran: <span class="font-medium text-slate-700">{{ $application->created_at->format('d/m/Y H:i') }}</span></p>
            </div>
        </article>
    @empty
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
                    class="mt-5 inline-flex rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                >
                    Cari Lowongan
                </a>
            </div>
        </div>
    @endforelse

    @if ($applications->hasPages())
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @endif

@endsection