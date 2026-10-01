@extends('layouts.job-seeker')

@section('title', 'Dashboard Pencari Kerja')

@section('dashboard-content')

    {{-- Hero Section --}}
    <section class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-blue-700 px-8 py-10 text-white shadow-xl md:px-12 md:py-14">

        {{-- Background Decoration --}}
        <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10"></div>
        <div class="absolute -bottom-24 -left-20 h-72 w-72 rounded-full bg-blue-400/10"></div>

        <div class="relative max-w-3xl">

            <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-1.5 text-sm font-medium text-indigo-50 ring-1 ring-white/20">
                🚀 Temukan Karier Impianmu
            </span>

            <h1 class="mt-5 text-3xl font-extrabold tracking-tight sm:text-4xl lg:text-5xl">
                Halo, {{ auth()->user()->name }}! 👋
            </h1>

            <p class="mt-5 max-w-2xl text-base leading-7 text-indigo-100 sm:text-lg">
                Temukan lowongan pekerjaan yang sesuai dengan kemampuan,
                pengalaman, dan tujuan kariermu.
            </p>

            <div class="mt-8 flex flex-wrap gap-3">

                <a
                    href="{{ route('job-seeker.lowongan') }}"
                    class="inline-flex items-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-indigo-700 shadow-lg transition hover:-translate-y-0.5 hover:bg-indigo-50"
                >
                    Cari Lowongan
                    <svg class="ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                <a
                    href="{{ route('job-seeker.profile') }}"
                    class="inline-flex items-center rounded-xl border border-white/30 bg-white/10 px-6 py-3 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/20"
                >
                    Lengkapi Profil
                </a>

            </div>
        </div>
    </section>


    {{-- Quick Information --}}
    <section class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

        {{-- Lowongan --}}
        <a
            href="{{ route('job-seeker.lowongan') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg"
        >
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 5h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <h2 class="mt-5 text-lg font-bold text-slate-900">
                Cari Lowongan
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Jelajahi berbagai lowongan pekerjaan yang tersedia.
            </p>

            <span class="mt-4 inline-block text-sm font-semibold text-indigo-600 group-hover:underline">
                Lihat lowongan →
            </span>
        </a>


        {{-- Riwayat --}}
        <a
            href="{{ route('job-seeker.riwayat') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg"
        >
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h2 class="mt-5 text-lg font-bold text-slate-900">
                Riwayat Lamaran
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Pantau pekerjaan yang sudah pernah kamu lamar.
            </p>

            <span class="mt-4 inline-block text-sm font-semibold text-blue-600 group-hover:underline">
                Lihat riwayat →
            </span>
        </a>


        {{-- Profile --}}
        <a
            href="{{ route('job-seeker.profile') }}"
            class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-indigo-200 hover:shadow-lg"
        >
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>

            <h2 class="mt-5 text-lg font-bold text-slate-900">
                Profil Saya
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                Lengkapi profil dan CV agar lebih siap melamar pekerjaan.
            </p>

            <span class="mt-4 inline-block text-sm font-semibold text-purple-600 group-hover:underline">
                Kelola profil →
            </span>
        </a>

    </section>

@endsection