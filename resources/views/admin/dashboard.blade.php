@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('dashboard-content')
    <div class="dashboard-card">
        <h1>Dashboard Admin</h1>
        <p class="subtitle">Selamat datang, {{ auth()->user()->name }}.</p>

        <ul>
            <li>Total pengguna: {{ $userCount }}</li>
            <li>Total perusahaan: {{ $companyCount }}</li>
            <li>Total lowongan: {{ $jobPostingCount }}</li>
            <li>Total lamaran: {{ $applicationCount }}</li>
        </ul>
    </div>
@endsection