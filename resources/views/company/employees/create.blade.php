@extends('layouts.company')

@section('title', 'Tambah Karyawan')

@section('dashboard-content')
<div class="container mx-auto max-w-2xl p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Karyawan</h1>

    @if ($errors->any())
    <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('company.employees.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="employee_name" class="block mb-1">Nama Karyawan</label>
            <input id="employee_name" name="employee_name" type="text"
                value="{{ old('employee_name', $defaultName ?? '') }}" required
                class="w-full rounded border p-2">
        </div>

        <div class="mb-4">
            <label for="position" class="block mb-1">Jabatan</label>
            <input id="position" name="position" type="text"
                value="{{ old('position') }}" required
                class="w-full rounded border p-2">
        </div>

        <div class="mb-4">
            <label for="department" class="block mb-1">Divisi</label>
            <input id="department" name="department" type="text"
                value="{{ old('department') }}"
                class="w-full rounded border p-2">
        </div>

        <div class="mb-4">
            <label for="hire_date" class="block mb-1">Tanggal Mulai Bekerja</label>
            <input id="hire_date" name="hire_date" type="date"
                value="{{ old('hire_date') }}" required
                class="w-full rounded border p-2">
        </div>

        <div class="mb-4">
            <label for="employment_status" class="block mb-1">Status</label>
            <select id="employment_status" name="employment_status" required
                class="w-full rounded border p-2">
                <option value="active"
                    {{ old('employment_status', 'active') === 'active' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="inactive"
                    {{ old('employment_status') === 'inactive' ? 'selected' : '' }}>
                    Tidak Aktif
                </option>
                <option value="resigned"
                    {{ old('employment_status') === 'resigned' ? 'selected' : '' }}>
                    Resign
                </option>
                <option value="resigned"
                    {{ old('employment_status') === 'bos' ? 'selected' : '' }}>
                    Bos
                </option>
            </select>
        </div>

        <button type="submit"
            class="rounded bg-blue-600 px-4 py-2 text-white">
            Simpan
        </button>

        <a href="{{ route('company.employees.index') }}" class="ml-2 text-gray-600">
            Batal
        </a>
    </form>
</div>
@endsection