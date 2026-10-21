@extends('layouts.company')

@section('title', 'Tambah Kategori')

@section('dashboard-content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Tambah Kategori</h1>
    </div>

    <div class="rounded-lg border border-slate-200 bg-white p-6">
        <form method="POST" action="{{ route('company.category.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold mb-1">Nama Kategori</label>
                {{-- Syarat Retensi Input: old() --}}
                <input type="text" name="name" value="{{ old('name') }}"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">
                {{-- Syarat Pesan Error: @error --}}
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold mb-1">Deskripsi (Opsional)</label>
                <textarea name="description"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2">{{ old('description') }}</textarea>
                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <a href="{{ route('company.category.index') }}" class="px-4 py-2 border rounded-lg">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
@endsection