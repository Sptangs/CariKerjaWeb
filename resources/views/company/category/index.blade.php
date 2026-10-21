@extends('layouts.company')

@section('title', 'Kategori Lowongan')

@section('dashboard-content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kategori Lowongan</h1>
            <p class="text-sm text-slate-500">Kelola daftar kategori untuk lowongan pekerjaan.</p>
        </div>
        <a href="{{ route('company.category.create') }}"
            class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Tambah
            Kategori</a>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-4 py-3">Nama Kategori</th>
                    <th class="px-4 py-3">Deskripsi</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b border-slate-100">
                        <td class="px-4 py-3 font-semibold">{{ $category->name }}</td>
                        <td class="px-4 py-3 text-slate-600">{{ $category->description ?? '-' }}</td>
                        <td class="px-4 py-3">

                            @if($category->description)
                                <span
                                    class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Lengkap</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Belum ada
                                    deskripsi</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex gap-2">
                            <a href="{{ route('company.category.edit', $category) }}"
                                class="text-blue-600 hover:underline text-xs font-semibold">Edit</a>
                            <form method="POST" action="{{ route('company.category.destroy', $category) }}"
                                onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs font-semibold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada data kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection