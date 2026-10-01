@extends('layouts.company')

@section('title', 'Dashboard Perusahaan')

@section('dashboard-content')
    <div class="dashboard-card">
        <h1>Dashboard Perusahaan</h1>
        <p class="subtitle">Selamat datang, {{ auth()->user()->name }}.</p>
        <p>Fitur pengelolaan lowongan dan pelamar akan tersedia di sini.</p>
    </div>
@endsection