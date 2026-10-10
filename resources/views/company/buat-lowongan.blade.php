@extends('layouts.company')

@section('title', 'Buat Lowongan')

@section('dashboard-content')
    <section>
        <div class="mb-6">
            <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Kelola Lowongan</p>
            <h1 class="mt-1 text-3xl font-bold text-slate-900">Buat Lowongan</h1>
            <p class="mt-1 text-sm text-slate-500">Lengkapi detail posisi untuk kandidat.</p>
        </div>

        {{-- error alert --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <div class="flex items-start gap-3">
                    <span class="text-red-600 font-bold">!</span>
                    <div>
                        <p class="text-sm font-semibold text-red-800">Data belum dapat disimpan.</p>
                        <p class="text-sm text-red-700">Periksa kembali terkait gaji.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="rounded-lg border border-slate-200 bg-white p-6 sm:p-8">
            <form action="{{ route('company.lowongan.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="title" class="mb-1.5 block font-semibold">Judul</label>
                    <input id="title" name="title" value="{{ old('title') }}" required
                        placeholder="Contoh: Backend Developer"
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="location" class="mb-1.5 block font-semibold">Lokasi</label>
                        <input id="location" name="location" value="{{ old('location') }}" required placeholder="Kota kerja"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="employment_type" class="mb-1.5 block font-semibold">Tipe Pekerjaan</label>
                        <select id="employment_type" name="employment_type" required
                            style="appearance:none; background-image:url('data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%2364748b\' stroke-width=\'2\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M19 9l-7 7-7-7\'/></svg>'); background-repeat:no-repeat; background-position:right 1rem center; background-size:1.25rem; padding-right:2.5rem;"
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">

                            <option value="">Pilih tipe</option>
                            <option value="Full-time" {{ old('employment_type') === 'Full-time' ? 'selected' : '' }}>Full-time
                            </option>
                            <option value="Kontrak" {{ old('employment_type') === 'Kontrak' ? 'selected' : '' }}>Kontrak
                            </option>
                            <option value="Magang" {{ old('employment_type') === 'Magang' ? 'selected' : '' }}>Magang</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="salary_min" class="mb-1.5 block font-semibold">Gaji Minimum (Rp)</label>
                        <input id="salary_min" name="salary_min" type="number" value="{{ old('salary_min') }}"
                            placeholder="5.000.000"
                            class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="salary_max" class="mb-1.5 block font-semibold">Gaji Maksimum (Rp)</label>
                        <input id="salary_max" name="salary_max" type="number" value="{{ old('salary_max') }}"
                            placeholder="8.000.000"
                            class="w-full rounded-lg border px-4 py-2.5 text-sm placeholder-slate-400 focus:outline-none focus:ring-2
                                   {{ $errors->has('salary_max') ? 'border-red-500 text-red-700 focus:border-red-500 focus:ring-red-100' : 'border-slate-300 text-slate-800 focus:border-blue-500 focus:ring-blue-100' }}">
                        @error('salary_max')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="mb-1.5 block font-semibold">Deskripsi</label>
                    <textarea id="description" name="description" rows="5" required
                        placeholder="Jelaskan tanggung jawab posisi..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label for="requirements" class="mb-1.5 block font-semibold">Persyaratan</label>
                    <textarea id="requirements" name="requirements" rows="5" required
                        placeholder="Tuliskan kompetensi yang dibutuhkan..."
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('requirements') }}</textarea>
                </div>

                <div>
                    <label for="status" class="mb-1.5 block font-semibold">Status</label>
                    <select id="status" name="status" required
                        class="w-full rounded-lg border border-slate-300 px-4 py-2.5 text-sm text-slate-800 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">
                        <option value="open" {{ old('status') === 'open' ? 'selected' : '' }}>Tersedia</option>
                        <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 border-t border-slate-100 pt-5">
                    <a href="{{ route('company.lowongan') }}"
                        class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection