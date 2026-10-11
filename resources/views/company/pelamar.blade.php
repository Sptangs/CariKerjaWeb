@extends('layouts.company')

@section('title', 'Pelamar Lowongan')

@section('dashboard-content')
    <p class="text-xs font-bold uppercase tracking-wide text-blue-500">{{ $jobPosting->title }}</p>
    <h1 class="text-3xl font-bold text-slate-900">Pelamar Lowongan</h1>
    <p class="mt-1 text-sm text-slate-500">Tinjau {{ $applications->count() }} kandidat untuk posisi
        {{ $jobPosting->title }} di {{ $jobPosting->location }}
    </p>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($applications->isEmpty())
        <div class="mt-6 rounded-lg border border-slate-200 bg-white p-12 text-center">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50">
                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 8.25l4.5 4.5m0-4.5l-4.5 4.5" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-slate-700">Belum ada pelamar</h3>
            <p class="mt-2 text-sm text-slate-500">Lowongan ini belum menerima lamaran. Bagikan lowongan untuk menjangkau lebih
                banyak kandidat.</p>
            <a href="{{ route('company.lowongan') }}"
                class="mt-4 inline-block rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Kembali ke Lowongan
            </a>
        </div>
    @else
        <div class="mt-6 rounded-lg border border-slate-200 bg-white overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
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
                    @foreach($applications as $app)
                        <tr>
                            <td class="px-4 py-3">{{ $app->user->name }}</td>
                            <td class="px-4 py-3">{{ $app->user->email }}</td>
                            <td class="px-4 py-3">{{ $app->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-3">
                                <button type="button" onclick="bukaModalCover('{{ $app->user->name }}', `{{ $app->cover_letter }}`)"
                                    class="rounded border border-slate-300 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    Lihat
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                <button type="button"
                                    class="rounded border border-slate-300 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                    Unduh
                                </button>
                            </td>
                            <td class="px-4 py-3">
                                @if ($app->status === 'pending')
                                    <span
                                        class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Menunggu</span>
                                @elseif ($app->status === 'accepted')
                                    <span
                                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Diterima</span>
                                @elseif ($app->status === 'rejected')
                                    <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($app->status === 'pending')
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('company.pelamar.terima', $app) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs font-semibold">Terima</button>
                                        </form>
                                        <form method="POST" action="{{ route('company.pelamar.tolak', $app) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="bg-red-600 text-white px-3 py-1 rounded text-xs font-semibold">Tolak</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                function bukaModalCover(nama, cover) {
                    document.getElementById('coverNama').textContent = nama;
                    document.getElementById('coverIsi').textContent = cover || 'Tidak ada cover letter.';
                    document.getElementById('modalCover').showModal();
                }
            </script>
        </div>
    @endif
@endsection