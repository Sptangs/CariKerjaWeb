<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Perusahaan') - CariKerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head> 
<body class="dashboard-page dashboard-page--company">
    <header class="site-header site-header--company">
        <div class="container header-inner">
            <a href="{{ route('company.dashboard') }}" class="brand">CariKerja<span class="brand-tag">MITRA</span></a>
            <nav class="header-nav" aria-label="Navigasi perusahaan">
                <a href="{{ route('company.dashboard') }}">Dashboard perusahaan</a>
                <a href="{{ route('company.profile') }}">Profil perusahaan</a>
                <span class="nav-user">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button button-outline">Keluar</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="container dashboard-main">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="dashboard-layout">
            <aside class="dashboard-sidebar" aria-label="Menu perusahaan">
                <p class="sidebar-label">Perusahaan</p>
                <a class="sidebar-link sidebar-link--company" href="{{ route('company.dashboard') }}" aria-current="page">Ringkasan</a>
                <a class="sidebar-link sidebar-link--company" href="{{ route('company.profile') }}">Profil perusahaan</a>
            </aside>
            <section class="dashboard-content">
                @yield('dashboard-content')
            </section>
        </div>
    </main>

    <footer class="site-footer site-footer--company">
        <div class="container footer-inner">
            <strong>Area Perusahaan</strong>
            <span>Kelola lowongan dan pelamar perusahaan Anda.</span>
        </div>
    </footer>
</body>
</html>