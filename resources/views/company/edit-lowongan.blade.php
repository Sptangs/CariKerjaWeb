@extends('layouts.company')

@section('title', 'Edit Lowongan')

@section('dashboard-content')
    <h1>Edit Lowongan</h1>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="{{ route('company.lowongan.update', $jobPosting) }}">
        @csrf
        @method('PUT')
        <p>Judul: <input name="title" value="{{ old('title', $jobPosting->title) }}" required></p>
        <p>Lokasi: <input name="location" value="{{ old('location', $jobPosting->location) }}" required></p>
        <p>Tipe: <input name="employment_type" value="{{ old('employment_type', $jobPosting->employment_type) }}" required></p>
        <p>Gaji Min: <input name="salary_min" type="number" value="{{ old('salary_min', $jobPosting->salary_min) }}"></p>
        <p>Gaji Max: <input name="salary_max" type="number" value="{{ old('salary_max', $jobPosting->salary_max) }}"></p>
        <p>Deskripsi: <textarea name="description" required>{{ old('description', $jobPosting->description) }}</textarea></p>
        <p>Persyaratan: <textarea name="requirements" required>{{ old('requirements', $jobPosting->requirements) }}</textarea></p>
        <p>Status:
            <select name="status">
                <option value="open" {{ $jobPosting->status === 'open' ? 'selected' : '' }}>Tersedia</option>
                <option value="closed" {{ $jobPosting->status === 'closed' ? 'selected' : '' }}>Ditutup</option>
            </select>
        </p>
        <button type="submit">Update</button>
    </form>
@endsection