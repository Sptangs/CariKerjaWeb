@extends('layouts.job-seeker')

@section('title', 'Dashboard Pencari Kerja')

@section('dashboard-content')

    {{-- Hero --}}
    <section class="relative overflow-hidden rounded-2xl bg-indigo-700 px-6 py-8 sm:px-8 sm:py-10 lg:px-10">
        <div class="relative z-10 max-w-3xl">
            <p class="text-sm font-medium text-indigo-200">
                Dashboard pencari kerja
            </p>

            <h1 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Temukan pekerjaan yang sesuai dengan potensimu.
            </h1>

            <p class="mt-3 max-w-xl text-sm leading-6 text-indigo-100 sm:text-base">
                Jelajahi peluang karier dari berbagai perusahaan dan
                temukan pekerjaan yang sesuai dengan tujuanmu.
            </p>

            <form method="GET"
                  action="{{ route('job-seeker.lowongan') }}"
                  class="mt-7 flex max-w-2xl flex-col gap-2 rounded-xl bg-white p-2 sm:flex-row">

                <div class="flex min-w-0 flex-1 items-center gap-3 px-3">
                    <svg class="h-5 w-5 shrink-0 text-slate-400"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <circle cx="11" cy="11" r="7"
                                stroke-width="1.8"/>
                        <path stroke-linecap="round"
                              stroke-width="1.8"
                              d="m16 16 4 4"/>
                    </svg>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Posisi atau nama perusahaan"
                        aria-label="Cari posisi atau perusahaan"
                        class="w-full min-w-0 border-0 bg-transparent py-3 text-sm text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-0"
                    >
                </div>

                <button type="submit"
                        class="inline-flex shrink-0 items-center justify-center rounded-lg bg-indigo-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Cari pekerjaan
                </button>
            </form>

            <div class="mt-5 flex flex-wrap gap-x-6 gap-y-3 text-sm">
                <a href="{{ route('job-seeker.profile') }}"
                   class="inline-flex items-center gap-2 text-indigo-100 transition hover:text-white">
                    <svg class="h-4 w-4"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <circle cx="12" cy="8" r="4"
                                stroke-width="1.8"/>
                        <path stroke-linecap="round"
                              stroke-width="1.8"
                              d="M4 21a8 8 0 0 1 16 0"/>
                    </svg>
                    Kelola profil dan CV
                </a>

                <a href="{{ route('job-seeker.riwayat') }}"
                   class="inline-flex items-center gap-2 text-indigo-100 transition hover:text-white">
                    <svg class="h-4 w-4"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <circle cx="12" cy="12" r="9"
                                stroke-width="1.8"/>
                        <path stroke-linecap="round"
                              stroke-width="1.8"
                              d="M12 7v5l3 2"/>
                    </svg>
                    Riwayat lamaran
                </a>
            </div>
        </div>

        {{-- Dekorasi minimalis --}}
        <div class="pointer-events-none absolute -right-20 -top-24 hidden h-72 w-72 rounded-full border-[48px] border-indigo-600/50 lg:block"></div>
        <div class="pointer-events-none absolute -bottom-32 right-32 hidden h-64 w-64 rounded-full bg-indigo-600/40 lg:block"></div>
    </section>


    {{-- Rekomendasi Lowongan --}}
    <section class="mt-9">

        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-indigo-600">
                    Peluang karier
                </p>

                <h2 class="mt-2 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                    Lowongan terbaru
                </h2>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Temukan peluang kerja dari berbagai perusahaan.
                </p>
            </div>

            <a href="{{ route('job-seeker.lowongan') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 transition hover:text-indigo-800">
                Lihat semua lowongan
                <svg class="h-4 w-4"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M5 12h14m-6-6 6 6-6 6"/>
                </svg>
            </a>
        </div>

        <div class="mt-5 grid gap-4 lg:grid-cols-2">

            @forelse(($jobs ?? collect()) as $job)

                <article class="group flex flex-col rounded-xl border border-slate-200 bg-white p-5 transition duration-200 hover:border-indigo-200 hover:shadow-md sm:p-6">

                    <div class="flex items-start gap-4">

                        {{-- Logo placeholder --}}
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-lg font-bold text-indigo-600">
                            {{ strtoupper(substr($job->company->company_name ?? 'P', 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-semibold leading-6 text-slate-900 transition group-hover:text-indigo-700">
                                {{ $job->title }}
                            </h3>

                            <p class="mt-1 text-sm font-medium text-slate-600">
                                {{ $job->company->company_name ?? 'Perusahaan' }}
                            </p>

                            @if($job->created_at)
                                <p class="mt-1 text-xs text-slate-400">
                                    Dipublikasikan
                                    {{ $job->created_at->diffForHumans() }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        @if($job->location)
                            <span class="inline-flex items-center gap-1.5 rounded-md bg-slate-100 px-2.5 py-1.5 text-xs font-medium text-slate-600">
                                <svg class="h-3.5 w-3.5"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/>
                                    <circle cx="12" cy="10" r="2.5"
                                            stroke-width="1.8"/>
                                </svg>
                                {{ $job->location }}
                            </span>
                        @endif

                        @if($job->employment_type)
                            <span class="rounded-md bg-indigo-50 px-2.5 py-1.5 text-xs font-medium text-indigo-700">
                                {{ $job->employment_type }}
                            </span>
                        @endif
                    </div>

                    @if($job->description)
                        <p class="mt-4 text-sm leading-6 text-slate-500">
                            {{ \Illuminate\Support\Str::limit(strip_tags($job->description), 135) }}
                        </p>
                    @endif

                    <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">
                        <span class="text-xs text-slate-400">
                            Peluang karier
                        </span>

                        <a href="{{ route('job-seeker.lowongan') }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                            Jelajahi lowongan
                            <span aria-hidden="true">&rarr;</span>
                        </a>
                    </div>

                </article>

            @empty

                <div class="rounded-xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center lg:col-span-2">

                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                        <svg class="h-6 w-6"
                             xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <rect x="3" y="7" width="18" height="14"
                                  rx="2" stroke-width="1.8"/>
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18m-11 0v2h4v-2"/>
                        </svg>
                    </div>

                    <h3 class="mt-4 text-base font-semibold text-slate-900">
                        Belum ada lowongan untuk ditampilkan
                    </h3>

                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">
                        Lowongan yang tersedia akan muncul di sini.
                        Kamu juga bisa membuka halaman lowongan untuk melihat peluang lainnya.
                    </p>

                    <a href="{{ route('job-seeker.lowongan') }}"
                       class="mt-5 inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        Jelajahi semua lowongan
                    </a>
                </div>

            @endforelse

        </div>
    </section>


    {{-- Akses Cepat --}}
    <section class="mt-10">
        <div>
            <h2 class="text-lg font-bold text-slate-900">
                Kelola pencarian kerjamu
            </h2>
            <p class="mt-1 text-sm text-slate-500">
                Pastikan profil dan dokumenmu siap sebelum melamar.
            </p>
        </div>

        <div class="mt-4 grid gap-4 sm:grid-cols-2">

            <a href="{{ route('job-seeker.profile') }}"
               class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 transition hover:border-indigo-200 hover:shadow-sm">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="h-5 w-5"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Zm0 0v6h6M8 13h8M8 17h6"/>
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="text-sm font-semibold text-slate-900">
                        Profil dan CV
                    </h3>
                    <p class="mt-1 text-sm leading-5 text-slate-500">
                        Perbarui informasi dan dokumen lamaranmu.
                    </p>
                </div>

                <svg class="h-5 w-5 shrink-0 text-slate-400"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8" d="m9 18 6-6-6-6"/>
                </svg>
            </a>

            <a href="{{ route('job-seeker.riwayat') }}"
               class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-5 transition hover:border-indigo-200 hover:shadow-sm">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="h-5 w-5"
                         xmlns="http://www.w3.org/2000/svg"
                         fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <circle cx="12" cy="12" r="9"
                                stroke-width="1.8"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M12 7v5l3 2"/>
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <h3 class="text-sm font-semibold text-slate-900">
                        Riwayat lamaran
                    </h3>
                    <p class="mt-1 text-sm leading-5 text-slate-500">
                        Pantau perkembangan lamaran yang telah dikirim.
                    </p>
                </div>

                <svg class="h-5 w-5 shrink-0 text-slate-400"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8" d="m9 18 6-6-6-6"/>
                </svg>
            </a>

        </div>
    </section>

@endsection