@extends('layouts.app')

@section('title', 'Dashboard Pencari Kerja')

@section('content')
    <div class="card">
        <h1>Dashboard Pencari Kerja</h1>
        <p class="subtitle">Selamat datang, {{ auth()->user()->name }}.</p>
        <p>Fitur cari lowongan dan riwayat lamaran akan tersedia di sini.</p>
    </div>
@endsection
