@extends('layouts.company')

@section('title', 'Dashboard Perusahaan')

@section('dashboard-content')
    <div class="mb-5">
        <p class="text-xs font-semibold uppercase tracking-wide text-blue-600">Ringkasan Perusahaan</p>
        <h1 class="text-3xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-sm text-slate-500 ">Pantau lowongan dan pelamar {{ auth()->user()->name }}.</p>
    </div>

    {{-- 4 kotak --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-5">
        <div class="rounded-lg border border-slate-200 bg-white p-5 relative">
            <span class="absolute top-4 right-4 h-2 w-2 rounded-full bg-blue-500"></span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Lowongan</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalLowongan }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 relative">
            <span class="absolute top-4 right-4 h-2 w-2 rounded-full bg-emerald-500"></span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Lowongan Aktif</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $lowonganAktif }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 relative">
            <span class="absolute top-4 right-4 h-2 w-2 rounded-full bg-blue-500"></span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Total Pelamar</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalPelamar }}</p>
        </div>
        <div class="rounded-lg border border-slate-200 bg-white p-5 relative">
            <span class="absolute top-4 right-4 h-2 w-2 rounded-full bg-amber-500"></span>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Pelamar Menunggu</p>
            <p class="text-3xl font-bold text-slate-900 mt-2">{{ $pelamarMenunggu }}</p>
        </div>
    </div>

    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-900">Pelamar Terbaru</h2>
            <p class="text-sm text-slate-500 mt-1">Lima kandidat yang baru mengirim lamaran.</p>
        </div>
        <a href="{{ route('company.lowongan') }}"
            class="rounded-lg bg-white border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Lihat Semua</a>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50">
                    <tr class="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Cover Letter</th>
                        <th class="px-4 py-3">CV</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pelamarTerbaru as $pelamar)
                        <tr class="border-b border-slate-100">
                            <td class="px-4 py-3 font-semibold">{{ $pelamar->user->name }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $pelamar->user->email }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $pelamar->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-slate-600">
                                <button type="button"
                                    onclick="munculCover('{{ $pelamar->user->name }}', `{{ $pelamar->cover_letter }}`)"
                                    class="rounded bg-100 border border-blue-200 px-3 py-2 font-semibold text-slate-800 hover:underline text-xs font-semibold">
                                    Lihat
                                </button>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                <button type="button"
                                    class="rounded bg-100 border border-blue-200 px-3 py-2 font-semibold text-slate-800 hover:underline text-xs font-semibold">
                                    Unduh
                                </button>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                @if ($pelamar->status === 'pending')
                                    <span
                                        class="rounded-full bg-amber-200 px-3 py-1 text-xs font-semibold text-amber-800">Menunggu</span>
                                @elseif($pelamar->status === 'accepted')
                                    <span
                                        class="rounded-full bg-emerald-200 px-3 py-1 text-xs font-semibold text-emerald-800">Diterima</span>
                                @else
                                    <span
                                        class="rounded-full bg-red-200 px-3 py-1 text-xs font-semibold text-red-800">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                @if ($pelamar->status === 'pending')
                                    <form method="POST" action="{{ route('company.pelamar.terima', $pelamar) }}"
                                        style="display:inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="rounded bg-blue-600 px-3 py-2 text-xs font-semibold text-white">Terima</button>
                                    </form>
                                    <form method="POST" action="{{ route('company.pelamar.tolak', $pelamar) }}"
                                        style="display:inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="rounded bg-red-600 px-3 py-2 text-xs font-semibold text-white">Tolak</button>
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
    <dialog id="modalCover" class="m-auto rounded-lg p-0 backdrop:bg-slate-900/50">
        <div class="w-[500px] rounded-lg bg-white p-6">
            <h3 class="text-lg font-bold text-slate-900">Cover Letter — <span id="coverNama"></span></h3>
            <p class="mt-4 whitespace-pre-line text-sm text-slate-700" id="coverIsi"></p>
            <div class="mt-6 flex justify-end">
                <button type="button" onclick="document.getElementById('modalCover').close()"
                    class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Tutup
                </button>
            </div>
        </div>
    </dialog>
    <script>
        function munculCover(nama, cover) {
            document.getElementById('coverNama').textContent = nama;
            document.getElementById('coverIsi').textContent = cover || 'Tidak ada cover letter.';
            document.getElementById('modalCover').showModal();
        }
    </script>
@endsection