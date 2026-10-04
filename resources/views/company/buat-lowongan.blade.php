@extends('layouts.company')
@section('title', 'Buat Lowongan')

@section('dashboard-content')
        <h1>Buat Lowongan</h1>
        @if ($errors->any())
            <ul style="color:red">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <form action="{{ route('company.lowongan.store') }}" method="POST">
            @csrf

        <p>Judul: <input name="title" value="{{ old('title') }}" required></p>
        <p>Lokasi: <input name="location" value="{{ old('location') }}" required></p>
        <p>Tipe: <input name="employment_type" value="{{ old('employment_type') }}" required></p>
        <p>Gaji Min: <input name="salary_min" type="number" value="{{ old('salary_min') }}"></p>
        <p>Gaji Max: <input name="salary_max" type="number" value="{{ old('salary_max') }}"></p>
        <p>Deskripsi: <textarea name="description" required>{{ old('description') }}</textarea></p>
        <p>Persyaratan: <textarea name="requirements" required>{{ old('requirements') }}</textarea></p>
        <p>Status:
            <select name="status">
                <option value="open">Tersedia</option>
                <option value="closed">Ditutup</option>
            </select>
        </p>
        <button type="submit">Simpan</button>
    </form>
@endsection