@extends('layouts.job-seeker')

@section('title', 'Profil Saya')

@section('dashboard-content')
<section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
    <div class="mb-6 border-b border-slate-100 pb-5">
        <h1 class="text-2xl font-bold text-slate-900">
            Profil Saya
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Perbarui informasi akun dan data profesional Anda.
        </p>
    </div>

    @if (session('success'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="mt-0.5 h-5 w-5 shrink-0"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>

        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if (session('error'))
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="mt-0.5 h-5 w-5 shrink-0"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 9v3.75m0 3h.008v.008H12v-.008ZM10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z" />
        </svg>

        <span>{{ session('error') }}</span>
    </div>
    @endif
    <form
        method="POST"
        action="{{ route('job-seeker.profile.update') }}"
        enctype="multipart/form-data"
        class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label
                    for="name"
                    class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Nama lengkap
                </label>

                <input
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">

                @error('name')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div>
                <label
                    for="email"
                    class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Email
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">

                @error('email')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div>
                <label
                    for="phone"
                    class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Nomor telepon
                </label>

                <input
                    id="phone"
                    name="phone"
                    type="tel"
                    value="{{ old('phone', $profile?->phone) }}"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">

                @error('phone')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div>
                <label
                    for="education"
                    class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Pendidikan terakhir
                </label>

                <input
                    id="education"
                    name="education"
                    value="{{ old('education', $profile?->education) }}"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">

                @error('education')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="sm:col-span-2">
                <label
                    for="address"
                    class="mb-1.5 block text-sm font-semibold text-slate-700">
                    Alamat
                </label>

                <textarea
                    id="address"
                    name="address"
                    rows="3"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('address', $profile?->address) }}</textarea>

                @error('address')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div class="sm:col-span-2">

                <label class="mb-2 block text-sm font-semibold text-slate-700">
                    Curriculum Vitae
                </label>

                @if ($profile?->cv_path)

                <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-4 sm:p-5">

                    {{-- Informasi CV --}}
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex min-w-0 items-center gap-4">

                            {{-- Icon File --}}
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-indigo-600 shadow-sm ring-1 ring-indigo-100">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.5 14.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-6.69a2.25 2.25 0 0 0-1.59.659L5.91 8.22a2.25 2.25 0 0 0-.66 1.591V17.25A2.25 2.25 0 0 0 7.5 19.5h4.5m7.5-5.25h-3.75a2.25 2.25 0 0 0-2.25 2.25v0a2.25 2.25 0 0 0 2.25 2.25H19.5m0-4.5v4.5" />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <div class="mb-1 flex flex-wrap items-center gap-2">

                                    <h3 class="font-semibold text-slate-900">
                                        CV Anda
                                    </h3>

                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-semibold text-emerald-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                        Tersimpan

                                    </span>

                                </div>


                                <p
                                    class="truncate text-sm font-medium text-slate-700"
                                    title="{{ basename($profile->cv_path) }}">
                                    {{ basename($profile->cv_path) }}
                                </p>


                                <p class="mt-1 text-xs text-slate-500">
                                    CV Anda sudah tersimpan dan siap digunakan untuk melamar pekerjaan.
                                </p>

                            </div>

                        </div>

                        <div class="flex shrink-0 flex-wrap gap-2">
                            <a
                                href="{{ route('job-seeker.profile.cv') }}"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-indigo-700 shadow-sm ring-1 ring-indigo-200 transition hover:bg-indigo-50">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M7.5 12l4.5 4.5m0 0 4.5-4.5M12 16.5V3" />
                                </svg>

                                Unduh

                            </a>

                            <button
                                type="button"
                                onclick="document.getElementById('delete-cv-modal').classList.remove('hidden')"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm ring-1 ring-red-200 transition hover:bg-red-50">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 7h12m-9 0v10m6-10v10M9 7V4.75A.75.75 0 0 1 9.75 4h4.5a.75.75 0 0 1 .75.75V7m-9 0 .75 13h9.5L18 7" />
                                </svg>

                                Hapus

                            </button>

                        </div>

                    </div>

                    <div class="mt-4 border-t border-indigo-100 pt-4">

                        <label
                            for="cv"
                            class="mb-2 block text-sm font-semibold text-slate-700">
                            Ganti CV
                        </label>

                        <input
                            id="cv"
                            name="cv"
                            type="file"
                            accept=".pdf,.doc,.docx"
                            class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:font-semibold file:text-indigo-700 file:ring-1 file:ring-indigo-200 hover:file:bg-indigo-50">

                        <p class="mt-1.5 text-xs text-slate-500">
                            Pilih file baru jika ingin mengganti CV.
                            PDF, DOC, atau DOCX, maksimal 5 MB.
                        </p>

                    </div>

                </div>
                @else

                <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center transition hover:border-indigo-300 hover:bg-indigo-50/30">

                    {{-- Icon Upload --}}
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 16.5V3.75m0 0L7.5 8.25M12 3.75l4.5 4.5M6.75 15v2.25A2.25 2.25 0 0 0 9 19.5h6a2.25 2.25 0 0 0 2.25-2.25V15" />
                        </svg>

                    </div>


                    <h3 class="mt-3 text-sm font-semibold text-slate-900">
                        Upload CV Anda
                    </h3>


                    <p class="mt-1 text-sm text-slate-500">
                        Tambahkan CV agar perusahaan dapat melihat profil profesional Anda.
                    </p>


                    <div class="mt-4">

                        <input
                            id="cv"
                            name="cv"
                            type="file"
                            accept=".pdf,.doc,.docx"
                            class="mx-auto block w-full max-w-md text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:font-semibold file:text-white hover:file:bg-indigo-700">

                    </div>


                    <p class="mt-2 text-xs text-slate-500">
                        PDF, DOC, atau DOCX · Maksimal 5 MB
                    </p>

                </div>

                @endif


                @error('cv')
                <p class="mt-2 text-sm text-red-600">
                    {{ $message }}
                </p>
                @enderror

            </div>

        </div>
        <div class="flex justify-end border-t border-slate-100 pt-5">

            <button
                type="submit"
                class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Simpan profil
            </button>

        </div>

    </form>

</section>

@if ($profile?->cv_path)

<div
    id="delete-cv-modal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 p-4 backdrop-blur-sm">

    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">

        {{-- Icon --}}
        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 9v3.75m0 3h.008v.008H12v-.008ZM10.29 3.86 2.82 17.25A1.5 1.5 0 0 0 4.13 19.5h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.95 1.95 0 0 0-3.42 0Z" />
            </svg>

        </div>


        <h2 class="mt-4 text-lg font-bold text-slate-900">
            Hapus CV?
        </h2>


        <p class="mt-2 text-sm leading-6 text-slate-500">

            CV

            <span class="font-semibold text-slate-700">
                {{ basename($profile->cv_path) }}
            </span>

            akan dihapus dari profil Anda.

            <br>

            Tindakan ini tidak dapat dibatalkan.

        </p>
        <div class="mt-6 flex justify-end gap-3">

            <button
                type="button"
                onclick="document.getElementById('delete-cv-modal').classList.add('hidden')"
                class="rounded-lg border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Batal
            </button>
            <form
                method="POST"
                action="{{ route('job-seeker.profile.cv.delete') }}">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                    Ya, Hapus CV
                </button>

            </form>

        </div>

    </div>

</div>

@endif

@endsection