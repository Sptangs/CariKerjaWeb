@extends('layouts.company')

@section('title', 'Dashboard Perusahaan')

@section('dashboard-content')
    {{-- header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-sm text-slate-500 mt-1">Pantau lowongan dan pelamar {{ auth()->user()->name }}.</p>
    </div>

    {{-- 4 kotak --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Lowongan</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalLowongan }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Lowongan Aktif</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $lowonganAktif }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pelamar</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalPelamar }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Pelamar Menunggu</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $pelamarMenunggu }}</p>
        </div>
    </div>

    {{-- tabel --}}
    <div class="rounded-lg border border-slate-200 bg-white p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-slate-900">Pelamar Terbaru</h2>
            <a href="{{ route('company.lowongan') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Tanggal</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Cover Letter</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">CV</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelamarTerbaru as $pelamar)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3">{{ $pelamar->user->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $pelamar->user->email }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $pelamar->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ Str::limit($pelamar->cover_letter, 30) }}</td>
                            <td class="px-4 py-3 text-slate-600">-</td>
                            <td class="px-4 py-3">
                                @if($pelamar->status === 'pending')
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Menunggu</span>
                                @elseif($pelamar->status === 'accepted')
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Diterima</span>
                                @else
                                <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($pelamar->status === 'pending')
                                <form method="POST" action="{{ route('company.pelamar.terima', $pelamar) }}" style="display:inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="rounded bg-blue-600 px-3 py-1 text-xs font-semibold text-white hover:bg-blue-700">Terima</button>
                            </form>
                            <form method="POST" action="{{ route('company.pelamar.tolak', $pelamar) }}" style="display:inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="rounded bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700">Tolak</button>
                                </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-slate-500">Belum ada pelamar.</td>
                </tr>
            @endforelse
        </tbody>
            </table>
        </div>
    </div>
@endsection