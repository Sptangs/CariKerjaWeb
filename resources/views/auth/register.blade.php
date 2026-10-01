@extends('layouts.app')

@section('title', 'Daftar')

@section('content')
    <div class="card card-narrow">
        <h1>Daftar</h1>
        <p class="subtitle">Buat akun CariKerja sebagai pencari kerja atau perusahaan.</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group @error('role') has-error @enderror">
                <label>Daftar sebagai</label>
                <div class="role-options">
                    <label class="role-card">
                        <input type="radio" name="role" value="job_seeker" {{ old('role', 'job_seeker') === 'job_seeker' ? 'checked' : '' }}>
                        Pencari Kerja
                    </label>
                    <label class="role-card">
                        <input type="radio" name="role" value="company" {{ old('role') === 'company' ? 'checked' : '' }}>
                        Perusahaan
                    </label>
                </div>
                @error('role')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('name') has-error @enderror">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('company_name') has-error @enderror" id="company-name-group" style="display: none;">
                <label for="company_name">Nama Perusahaan</label>
                <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}">
                @error('company_name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('email') has-error @enderror">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group @error('password') has-error @enderror">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </form>

        <p class="auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
    </div>
@endsection

@push('scripts')
    <script>
        // Tampilkan kolom "Nama Perusahaan" hanya jika memilih role Perusahaan
        const roleInputs = document.querySelectorAll('input[name="role"]');
        const companyGroup = document.getElementById('company-name-group');

        function toggleCompanyField() {
            const selected = document.querySelector('input[name="role"]:checked');
            companyGroup.style.display = selected && selected.value === 'company' ? 'block' : 'none';
        }

        roleInputs.forEach(function (input) {
            input.addEventListener('change', toggleCompanyField);
        });
        toggleCompanyField();
    </script>
@endpush