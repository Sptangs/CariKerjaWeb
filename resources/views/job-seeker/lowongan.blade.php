@extends('layouts.job-seeker')

@section('title', 'Lowongan Pekerjaan')

@section('dashboard-content')

{{-- Header --}}
<div class="mb-8">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">
            Lowongan Pekerjaan
        </h1>

        <p class="mt-2 text-sm text-slate-500 sm:text-base">
            Temukan pekerjaan yang sesuai dengan kemampuan dan minat kamu.
        </p>
    </div>
</div>


{{-- Search & Filter --}}
<div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="grid gap-3 md:grid-cols-3">

        {{-- Search --}}
        <div class="md:col-span-2">
            <label for="search" class="mb-2 block text-sm font-semibold text-slate-700">
                Cari Lowongan
            </label>

            <div class="relative">
                <svg
                    class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6.04 6.04a7.5 7.5 0 0 0 10.61 10.61Z" />
                </svg>

                <input
                    type="text"
                    id="search"
                    placeholder="Cari posisi atau perusahaan..."
                    class="w-full rounded-xl border border-slate-200 py-3 pl-11 pr-4 text-sm
                               text-slate-700 outline-none transition
                               placeholder:text-slate-400
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
            </div>
        </div>

        {{-- Location --}}
        <div>
            <label for="location" class="mb-2 block text-sm font-semibold text-slate-700">
                Lokasi
            </label>

            <select
                id="location"
                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm
                           text-slate-700 outline-none transition
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                <option value="">Semua Lokasi</option>
                <option value="madiun">Madiun</option>
                <option value="ponorogo">Ponorogo</option>
                <option value="surabaya">Surabaya</option>
                <option value="malang">Malang</option>
                <option value="jakarta">Jakarta</option>
            </select>
        </div>

    </div>
</div>


{{-- Jumlah Lowongan --}}
<div class="mb-5 flex items-center justify-between">
    <div>
        <h2 class="text-lg font-bold text-slate-900">
            Semua Lowongan
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            {{ $jobs->count() }} lowongan tersedia
        </p>
    </div>
</div>


{{-- List Lowongan --}}
@forelse ($jobs as $job)

<div class="group mb-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm
                    transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md">

    <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">

        {{-- Informasi Lowongan --}}
        <div class="flex gap-4">

            {{-- Logo Perusahaan --}}
            <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl
                                bg-indigo-50 text-lg font-bold text-indigo-600">
                {{ strtoupper(substr($job->company->company_name ?? 'P', 0, 1)) }}
            </div>

            <div>
                <h3 class="text-lg font-bold text-slate-900 transition group-hover:text-indigo-600">
                    {{ $job->title }}
                </h3>

                <p class="mt-1 text-sm font-medium text-slate-600">
                    {{ $job->company->company_name ?? 'Perusahaan' }}
                </p>

                <div class="mt-3 flex flex-wrap gap-2 text-xs text-slate-500">

                    @if ($job->location)
                    <span class="rounded-lg bg-slate-100 px-3 py-1.5">
                        📍 {{ $job->location }}
                    </span>
                    @endif

                    @if ($job->employment_type)
                    <span class="rounded-lg bg-indigo-50 px-3 py-1.5 text-indigo-700">
                        💼 {{ $job->employment_type }}
                    </span>
                    @endif

                </div>
            </div>
        </div>


        <a
            href="{{ route('job-seeker.lowongan.detail', $job->id) }}"
            class="inline-flex w-full items-center justify-center rounded-xl
           bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white
           transition hover:bg-indigo-700 sm:w-auto">
            Lihat Detail
        </a>

    </div>

    {{-- Deskripsi --}}
    @if ($job->description)
    <div class="mt-5 border-t border-slate-100 pt-4">
        <p class="line-clamp-2 text-sm leading-6 text-slate-500">
            {{ $job->description }}
        </p>
    </div>
    @endif

</div>

@empty

<div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-14 text-center">

    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">
        <svg
            class="h-8 w-8 text-slate-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M20 13V7a2 2 0 0 0-2-2h-3l-1-2H10L9 5H6a2 2 0 0 0-2 2v6m16 0v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4m16 0H4" />
        </svg>
    </div>

    <h3 class="mt-5 text-lg font-bold text-slate-900">
        Belum Ada Lowongan
    </h3>

    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
        Saat ini belum ada lowongan pekerjaan yang tersedia.
        Silakan cek kembali beberapa saat lagi.
    </p>

</div>

@endforelse

@endsection