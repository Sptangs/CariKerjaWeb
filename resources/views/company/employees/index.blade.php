@extends('layouts.company')

@section('title', 'Pekerja Perusahaan')

@section('dashboard-content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Manajemen Karyawan</h1>

    @if (session('success'))
        <div class="mb-4 rounded bg-green-100 p-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('company.employees.create') }}"
       class="inline-block rounded bg-blue-600 px-4 py-2 text-white mb-4">
        + Tambah Karyawan
    </a>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">No.</th>
                    <th class="border p-2">Nama Karyawan</th>
                    <th class="border p-2">Perusahaan</th>
                    <th class="border p-2">Jabatan</th>
                    <th class="border p-2">Divisi</th>
                    <th class="border p-2">Tanggal Masuk</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td class="border p-2 text-center">
                            {{ $employees->firstItem() + $loop->index }}
                        </td>
                        <td class="border p-2">
                            {{ $employee->employee_name }}
                        </td>
                        <td class="border p-2">
                            {{ $employee->company->company_name }}
                        </td>
                        <td class="border p-2">
                            {{ $employee->position }}
                        </td>
                        <td class="border p-2">
                            {{ $employee->department ?? '-' }}
                        </td>
                        <td class="border p-2 text-center">
                            {{ $employee->hire_date->format('d-m-Y') }}
                        </td>
                        <td class="border p-2 text-center">
                            @if ($employee->employment_status === 'active')
                                <span class="text-green-700 font-semibold">Aktif</span>
                            @elseif ($employee->employment_status === 'inactive')
                                <span class="text-gray-600 font-semibold">Tidak Aktif</span>
                            @else
                                <span class="text-red-700 font-semibold">Resign</span>
                            @endif
                        </td>
                        <td class="border p-2 whitespace-nowrap text-center">
                            <a href="{{ route('company.employees.edit', $employee) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <form action="{{ route('company.employees.destroy', $employee) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="text-red-600 ml-2 hover:underline">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="border p-4 text-center text-gray-500">
                            Belum ada data karyawan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
@endsection