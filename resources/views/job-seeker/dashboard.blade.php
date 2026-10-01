@extends('layouts.job-seeker')

@section('title', 'Dashboard Pencari Kerja')

@section('dashboard-content')
    <div class="dashboard-card">
        <h1>Dashboard Pencari Kerja</h1>
        <p class="subtitle">Selamat datang, {{ auth()->user()->name }}.</p>
        <p>Fitur cari lowongan dan riwayat lamaran akan tersedia di sini.</p>
    </div>
@endsection
