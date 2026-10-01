<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - CariKerja</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="dashboard-page dashboard-page--admin">
    <header class="site-header site-header--admin">
        <div class="container header-inner">
            <a href="{{ route('admin.dashboard') }}" class="brand">CariKerja<span class="brand-tag">ADMIN</span></a>
            <nav class="header-nav" aria-label="Navigasi admin">
                <a href="{{ route('admin.dashboard') }}">Panel admin</a>
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
            <aside class="dashboard-sidebar" aria-label="Menu admin">
                <p class="sidebar-label">Administrator</p>
                <a class="sidebar-link sidebar-link--admin" href="{{ route('admin.dashboard') }}" aria-current="page">Ringkasan</a>
            </aside>
            <section class="dashboard-content">
                @yield('dashboard-content')
            </section>
        </div>
    </main>

    <footer class="site-footer site-footer--admin">
        <div class="container footer-inner">
            <strong>Panel Administrator CariKerja</strong>
            <span>Pengelolaan platform dan akun.</span>
        </div>
    </footer>
</body>
</html>