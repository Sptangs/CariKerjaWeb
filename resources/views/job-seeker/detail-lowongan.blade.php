@extends('layouts.job-seeker')

@section('title', $job->title)

@section('dashboard-content')

    {{-- Back --}}
    <div class="mb-6">
        <a
            href="{{ route('job-seeker.lowongan') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600
                   transition-colors duration-200 hover:text-indigo-600"
        >
            <svg
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Kembali ke Lowongan
        </a>
    </div>

    @if (session('status'))
        <div role="status" class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-medium text-amber-800">
            {{ session('status') }}
        </div>
    @endif


    {{-- Job Header --}}
    <section
        class="overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-600 to-blue-700
               shadow-lg shadow-indigo-100"
    >
        <div class="p-6 sm:p-8 lg:p-10">

            <div class="flex flex-col gap-6 sm:flex-row sm:items-center">

                {{-- Company Logo --}}
                <div
                    class="flex h-20 w-20 shrink-0 items-center justify-center rounded-2xl
                           bg-white text-2xl font-extrabold text-indigo-600 shadow-md"
                >
                    {{ strtoupper(substr($job->company->company_name ?? 'P', 0, 1)) }}
                </div>


                {{-- Job Information --}}
                <div class="min-w-0">

                    <p class="mb-2 text-sm font-medium text-indigo-100">
                        Lowongan Pekerjaan
                    </p>

                    <h1
                        class="text-2xl font-extrabold leading-tight tracking-tight text-white
                               sm:text-3xl lg:text-4xl"
                    >
                        {{ $job->title }}
                    </h1>

                    <p class="mt-2 text-base font-medium text-indigo-100 sm:text-lg">
                        {{ $job->company->company_name ?? 'Perusahaan' }}
                    </p>


                    {{-- Tags --}}
                    <div class="mt-5 flex flex-wrap gap-2">

                        @if ($job->location)
                            <span
                                class="inline-flex items-center gap-2 rounded-lg bg-white/15
                                       px-3 py-2 text-sm font-medium text-white backdrop-blur-sm"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"
                                    />
                                    <circle
                                        cx="12"
                                        cy="11"
                                        r="2.5"
                                    />
                                </svg>

                                {{ $job->location }}
                            </span>
                        @endif


                        @if ($job->employment_type)
                            <span
                                class="inline-flex items-center gap-2 rounded-lg bg-white/15
                                       px-3 py-2 text-sm font-medium text-white backdrop-blur-sm"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 002 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V5h8v2"
                                    />
                                </svg>

                                {{ $job->employment_type }}
                            </span>
                        @endif


                        {{-- Status --}}
                        @if ($job->status)

                            @if (strtolower($job->status) === 'closed')
                                <span
                                    class="inline-flex items-center gap-2 rounded-lg bg-red-500/20
                                           px-3 py-2 text-sm font-semibold text-red-100"
                                >
                                    <span class="h-2 w-2 rounded-full bg-red-300"></span>
                                    Lowongan Ditutup
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center gap-2 rounded-lg bg-emerald-500/20
                                           px-3 py-2 text-sm font-semibold text-emerald-100"
                                >
                                    <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                                    Lowongan Aktif
                                </span>
                            @endif

                        @endif

                    </div>

                </div>

            </div>

        </div>
    </section>


    {{-- Main Content --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-3">


        {{-- Left Content --}}
        <div class="space-y-6 lg:col-span-2">


            {{-- Description --}}
            <section
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7"
            >

                <div class="flex items-center gap-3">

                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-xl
                               bg-indigo-50 text-indigo-600"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h10"
                            />
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-slate-900 sm:text-xl">
                            Deskripsi Pekerjaan
                        </h2>

                        <p class="mt-0.5 text-sm text-slate-500">
                            Informasi mengenai posisi yang tersedia
                        </p>
                    </div>

                </div>

                <div
                    class="mt-6 whitespace-pre-line text-sm leading-7 text-slate-600 sm:text-base"
                >
                    {{ $job->description }}
                </div>

            </section>


            {{-- Requirements --}}
            @if ($job->requirements)

                <section
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7"
                >

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl
                                   bg-emerald-50 text-emerald-600"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-slate-900 sm:text-xl">
                                Persyaratan
                            </h2>

                            <p class="mt-0.5 text-sm text-slate-500">
                                Kualifikasi yang dibutuhkan
                            </p>
                        </div>

                    </div>

                    <div
                        class="mt-6 whitespace-pre-line text-sm leading-7 text-slate-600 sm:text-base"
                    >
                        {{ $job->requirements }}
                    </div>

                </section>

            @endif

        </div>


        {{-- Right Sidebar --}}
        <aside class="lg:col-span-1">

            <div
                class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
            >

                <h2 class="text-lg font-bold text-slate-900">
                    Informasi Lowongan
                </h2>


                <div class="mt-6 space-y-5">


                    {{-- Company --}}
                    <div class="flex gap-3">

                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                   bg-slate-100 text-slate-600"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 7h2M9 11h2M9 15h2M13 7h2M13 11h2M13 15h2"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0">

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Perusahaan
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ $job->company->company_name ?? 'Perusahaan' }}
                            </p>

                        </div>

                    </div>


                    {{-- Location --}}
                    @if ($job->location)

                        <div class="flex gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                       bg-slate-100 text-slate-600"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 21s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"
                                    />
                                    <circle
                                        cx="12"
                                        cy="11"
                                        r="2.5"
                                    />
                                </svg>
                            </div>

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Lokasi
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">
                                    {{ $job->location }}
                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- Employment Type --}}
                    @if ($job->employment_type)

                        <div class="flex gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                       bg-slate-100 text-slate-600"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M8 7V5h8v2"
                                    />
                                </svg>
                            </div>

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Tipe Pekerjaan
                                </p>

                                <p class="mt-1 text-sm font-semibold text-slate-700">
                                    {{ $job->employment_type }}
                                </p>

                            </div>

                        </div>

                    @endif


                    {{-- Salary --}}
                    @if ($job->salary_min || $job->salary_max)

                        <div class="flex gap-3">

                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                                       bg-slate-100 text-slate-600"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.119-3 2.5S10.343 13 12 13s3 1.119 3 2.5S13.657 18 12 18m0-10V6m0 12v-2m0-10a6 6 0 100 12 6 6 0 000-12z"
                                    />
                                </svg>
                            </div>

                            <div class="min-w-0">

                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    Gaji
                                </p>

                                <p class="mt-1 text-sm font-bold text-indigo-600">

                                    @if ($job->salary_min && $job->salary_max)

                                        Rp {{ number_format($job->salary_min, 0, ',', '.') }}
                                        -
                                        Rp {{ number_format($job->salary_max, 0, ',', '.') }}

                                    @elseif ($job->salary_min)

                                        Mulai Rp {{ number_format($job->salary_min, 0, ',', '.') }}

                                    @elseif ($job->salary_max)

                                        Hingga Rp {{ number_format($job->salary_max, 0, ',', '.') }}

                                    @endif

                                </p>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- Divider --}}
                <div class="my-6 border-t border-slate-100"></div>


                {{-- Application Status --}}
                @if (strtolower($job->status) === 'closed' && !$hasApplied)

                    {{-- Lowongan Ditutup --}}
                    <div
                        class="rounded-xl border border-red-200 bg-red-50 p-4"
                    >
                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                       bg-red-100 text-red-600"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.74 3h15.58a2 2 0 001.74-3l-7.82-14a2 2 0 00-3.42 0z"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-red-800">
                                    Lowongan Ditutup
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-red-700">
                                    Lowongan ini sudah tidak menerima lamaran baru.
                                </p>
                            </div>

                        </div>
                    </div>


                @elseif ($hasApplied)

                    {{-- Sudah Melamar --}}
                    <div
                        class="rounded-xl border border-emerald-200 bg-emerald-50 p-4"
                    >
                        <div class="flex items-start gap-3">

                            <div
                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg
                                       bg-emerald-100 text-emerald-600"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-emerald-800">
                                    Sudah Melamar
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-emerald-700">
                                    Kamu sudah mengirim lamaran untuk lowongan ini.
                                </p>
                            </div>

                        </div>
                    </div>


                @else

                    {{-- Belum Melamar --}}
                    <form
                        method="POST"
                        action="{{ route('job-seeker.lowongan.apply', $job->id) }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl
                                   bg-indigo-600 px-5 py-3 text-sm font-bold text-white
                                   shadow-sm transition-all duration-200
                                   hover:-translate-y-0.5 hover:bg-indigo-700 hover:shadow-md
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500
                                   focus:ring-offset-2 active:translate-y-0"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 12h14M13 6l6 6-6 6"
                                />
                            </svg>

                            Lamar Sekarang
                        </button>
                    </form>

                    <p class="mt-3 text-center text-xs leading-5 text-slate-400">
                        Pastikan profil dan CV kamu sudah lengkap sebelum melamar.
                    </p>

                @endif

            </div>

        </aside>

    </div>

@endsection