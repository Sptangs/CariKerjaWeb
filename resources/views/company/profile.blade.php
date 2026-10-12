@extends('layouts.company')

@section('title', 'Profil Perusahaan')

@section('dashboard-content')
    <div class="mb-6">
        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Informasi Perusahaan</p>
        <h1 class="mt-1 text-3xl font-bold text-slate-900">Profil Perusahaan</h1>
        <p class="mt-1 text-sm text-slate-500">Pastikan profil perusahaan jelas dan menarik bagi kandidat.</p>
    </div>
    <section>
        <div class="rounded-lg border border-slate-200 bg-white p-6 sm:p-8">
            <form method="POST" action="{{ route('company.profile.update') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama kontak</label>
                        <input id="name" name="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email akun</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="company_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama
                            perusahaan</label>
                        <input id="company_name" name="company_name"
                            value="{{ old('company_name', $company?->company_name) }}" required
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                        @error('company_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Tentang
                            perusahaan</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('description', $company?->description) }}</textarea>
                        @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat
                            perusahaan</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('address', $company?->address) }}</textarea>
                        @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end border-t border-slate-100 pt-5">
                    <button type="submit"
                        class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </section>
@endsection