@extends('layouts.company')

@section('title', 'Profil Perusahaan')

@section('dashboard-content')
    <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <div class="mb-6 border-b border-slate-100 pb-5">
            <h1 class="text-2xl font-bold text-slate-900">Profil Perusahaan</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui informasi akun dan profil perusahaan Anda.</p>
        </div>

        <form method="POST" action="{{ route('company.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama kontak</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email akun</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="company_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama perusahaan</label>
                    <input id="company_name" name="company_name" value="{{ old('company_name', $company?->company_name) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">
                    @error('company_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Tentang perusahaan</label>
                    <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('description', $company?->description) }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat perusahaan</label>
                    <textarea id="address" name="address" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-100">{{ old('address', $company?->address) }}</textarea>
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">Simpan profil</button>
            </div>
        </form>
    </section>
@endsection