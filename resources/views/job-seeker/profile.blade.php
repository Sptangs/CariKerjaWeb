@extends('layouts.job-seeker')

@section('title', 'Profil Saya')

@section('dashboard-content')
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <div class="mb-6 border-b border-slate-100 pb-5">
            <h1 class="text-2xl font-bold text-slate-900">Profil Saya</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui informasi akun dan data profesional Anda.</p>
        </div>

        <form method="POST" action="{{ route('job-seeker.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-semibold text-slate-700">Nomor telepon</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone', $profile?->phone) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="education" class="mb-1.5 block text-sm font-semibold text-slate-700">Pendidikan terakhir</label>
                    <input id="education" name="education" value="{{ old('education', $profile?->education) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    @error('education') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat</label>
                    <textarea id="address" name="address" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('address', $profile?->address) }}</textarea>
                    @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="cv" class="mb-1.5 block text-sm font-semibold text-slate-700">Curriculum vitae</label>
                    @if ($profile?->cv_path)
                        <p class="mb-2 text-sm text-slate-600">
                            CV tersimpan. <a href="{{ route('job-seeker.profile.cv') }}" class="font-semibold text-indigo-700 hover:text-indigo-900">Unduh CV</a>
                        </p>
                    @endif
                    <input id="cv" name="cv" type="file" accept=".pdf,.doc,.docx" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    <p class="mt-1 text-xs text-slate-500">PDF, DOC, atau DOCX; maksimal 5 MB.</p>
                    @error('cv') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end border-t border-slate-100 pt-5">
                <button type="submit" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Simpan profil</button>
            </div>
        </form>
    </section>
@endsection