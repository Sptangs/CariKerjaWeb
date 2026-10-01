@extends('layouts.job-seeker')

@section('title', 'Lamar Pekerjaan')

@section('dashboard-content')

    <div class="mx-auto max-w-3xl">

        {{-- Header --}}
        <div class="mb-6">
            <a
                href="{{ route('job-seeker.lowongan.detail', $job->id) }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-indigo-600"
            >
                ← Kembali ke detail lowongan
            </a>

            <h1 class="mt-4 text-2xl font-bold text-slate-900">
                Lamar Pekerjaan
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Lengkapi alasan mengapa Anda cocok dengan posisi ini.
            </p>
        </div>

        {{-- Informasi Lowongan --}}
        <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start gap-4">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-indigo-100 font-bold text-indigo-600">
                    {{ strtoupper(substr($job->company->company_name ?? 'P', 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <h2 class="text-lg font-bold text-slate-900">
                        {{ $job->title }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $job->company->company_name ?? 'Perusahaan' }}
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ $job->location }}
                    </p>
                </div>

            </div>
        </div>

        {{-- Form Lamaran --}}
        <form
            method="POST"
            action="{{ route('job-seeker.lowongan.apply.store', $job->id) }}"
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7"
        >
            @csrf

            {{-- CV --}}
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    CV yang digunakan
                </label>

                <div class="flex items-center gap-4 rounded-xl border border-emerald-200 bg-emerald-50 p-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-white text-red-500 shadow-sm">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19.5 14.25v-8.25A2.25 2.25 0 0 0 17.25 3.75h-6.5L5.25 9.25v9.5A2.25 2.25 0 0 0 7.5 21h9.75a2.25 2.25 0 0 0 2.25-2.25v-4.5Z"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.75 3.75v5.5h-5.5"
                            />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-900">
                            {{ basename($profile->cv_path) }}
                        </p>

                        <p class="mt-1 text-xs text-emerald-700">
                            CV dari profil Anda akan digunakan untuk lamaran ini.
                        </p>
                    </div>

                </div>

                <div class="mt-2">
                    <a
                        href="{{ route('job-seeker.profile.cv') }}"
                        class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                    >
                        Lihat / unduh CV
                    </a>
                </div>
            </div>

            {{-- Cover Letter --}}
            <div class="mt-6">

                <label
                    for="cover_letter"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Mengapa Anda cocok dengan pekerjaan ini?
                </label>

                <textarea
                    id="cover_letter"
                    name="cover_letter"
                    rows="7"
                    required
                    minlength="30"
                    maxlength="5000"
                    placeholder="Jelaskan pengalaman, kemampuan, pendidikan, atau alasan yang membuat Anda cocok dengan posisi ini..."
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >{{ old('cover_letter') }}</textarea>

                <div class="mt-2 flex justify-between gap-4">
                    <p class="text-xs text-slate-500">
                        Minimal 30 karakter.
                    </p>

                    <p class="text-xs text-slate-400">
                        Maksimal 5000 karakter.
                    </p>
                </div>

                @error('cover_letter')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- Informasi --}}
            <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4">
                <div class="flex gap-3">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mt-0.5 h-5 w-5 shrink-0 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.25 11.25h1.5v5.25h-1.5zM12 7.5h.008v.008H12z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>

                    <p class="text-sm leading-6 text-blue-700">
                        Lamaran akan dikirim menggunakan CV yang saat ini tersimpan
                        di profil Anda. Pastikan CV Anda sudah diperbarui sebelum
                        mengirim lamaran.
                    </p>

                </div>
            </div>

            {{-- Button --}}
            <div class="mt-7 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('job-seeker.lowongan.detail', $job->id) }}"
                    class="rounded-xl border border-slate-200 px-5 py-2.5 text-center text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Kirim Lamaran
                </button>

            </div>

        </form>

    </div>

@endsection