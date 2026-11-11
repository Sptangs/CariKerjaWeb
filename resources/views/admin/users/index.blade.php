@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('dashboard-content')
    <div class="dashboard-card">
        <div class="mb-6 flex flex-wrap items-start justify-between gap-3">
            <div>
                <p class="subtitle">Daftar akun pelamar, perusahaan, dan admin CariKerja.</p>
            </div>
            <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                {{ $users->total() }} pengguna
            </span>
        </div>

        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-5 flex flex-wrap items-end gap-3">
            <div class="min-w-[220px] flex-1">
                <label for="search" class="mb-1 block text-sm font-semibold text-slate-700">Cari pengguna</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Nama atau email..."
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >
            </div>

            <div>
                <label for="role" class="mb-1 block text-sm font-semibold text-slate-700">Role</label>
                <select
                    id="role"
                    name="role"
                    class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                >
                    <option value="">Semua role</option>
                    @foreach ($roles as $value => $label)
                        <option value="{{ $value }}" @selected($role === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700"
                >
                    Cari
                </button>
                @if ($search !== '' || $role !== '')
                    <a
                        href="{{ route('admin.users.index') }}"
                        class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-left text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-slate-600">Nama</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Email</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Role</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Perusahaan</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Lamaran</th>
                        <th class="px-4 py-3 font-semibold text-slate-600">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span @class([
                                    'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset',
                                    'bg-indigo-50 text-indigo-700 ring-indigo-100' => $user->role === 'job_seeker',
                                    'bg-emerald-50 text-emerald-700 ring-emerald-100' => $user->role === 'company',
                                    'bg-slate-100 text-slate-700 ring-slate-200' => $user->role === 'admin',
                                ])>
                                    {{ $roles[$user->role] ?? $user->role }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $user->company?->company_name ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $user->applications_count }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $user->created_at?->format('d M Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500">
                                Tidak ada pengguna yang cocok dengan filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection
