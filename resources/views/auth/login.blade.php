@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div class="card card-narrow">
        <h1>Masuk</h1>
        <p class="subtitle">Masuk ke akun CariKerja Anda.</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group @error('email') has-error @enderror">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
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
                <label class="check">
                    <input type="checkbox" name="remember" value="1"> Ingat saya
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
        </form>

        <p class="auth-footer">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
    </div>
@endsection