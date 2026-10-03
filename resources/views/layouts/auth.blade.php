<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - CariKerja</title>
    <style>
        :root {
            --primary: #2563EB;
            --primary-dark: #1D4ED8;
            --bg: #F8FAFC;
            --border: #E2E8F0;
            --text: #0F172A;
            --muted: #64748B;
            --success-bg: #DCFCE7; --success-text: #166534;
            --error-bg: #FEE2E2; --error-text: #991B1B;
        }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: 'Instrument Sans', system-ui, sans-serif; background: var(--bg); color: var(--text); line-height: 1.5; }
        a { color: var(--primary); text-decoration: none; }
        .container { width: 100%; max-width: 1100px; margin: 0 auto; padding: 0 16px; }
        .main { padding-top: 24px; padding-bottom: 48px; }

        .dashboard-layout { display: grid; grid-template-columns: 220px minmax(0, 1fr); gap: 20px; align-items: start; }
        .dashboard-sidebar { padding: 16px; background: #fff; border: 1px solid var(--border); border-radius: 8px; }
        .dashboard-role { margin: 0 0 12px; color: var(--muted); font-size: 12px; font-weight: 700; text-transform: uppercase; }
        .dashboard-nav-link { display: block; padding: 10px 12px; border-radius: 6px; background: #EFF6FF; color: var(--primary); font-weight: 600; }
        .dashboard-content { min-width: 0; }

        .navbar { background: #fff; border-bottom: 1px solid var(--border); }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .brand { font-size: 20px; font-weight: 700; color: var(--primary); }
        .brand-tag { margin-left: 8px; font-size: 11px; font-weight: 700; letter-spacing: 0; vertical-align: middle; }
        .nav-links { display: flex; align-items: center; gap: 16px; }
        .nav-links form { margin: 0; }
        .nav-user { color: var(--muted); font-size: 14px; }
        .navbar-admin { background: #17212B; border-color: #34424F; }
        .navbar-admin .brand, .navbar-admin .nav-links > a { color: #fff; }
        .navbar-admin .brand-tag { color: #A7F3D0; }
        .navbar-admin .nav-user { color: #D5DEE7; }
        .navbar-job-seeker { background: #EFF6FF; border-color: #BFDBFE; }
        .navbar-job-seeker .brand, .navbar-job-seeker .nav-links > a { color: #1D4ED8; }
        .navbar-job-seeker .brand-tag { color: #1D4ED8; }
        .navbar-company { background: #ECFDF5; border-color: #A7F3D0; }
        .navbar-company .brand, .navbar-company .nav-links > a { color: #047857; }
        .navbar-company .brand-tag { color: #047857; }
        .site-footer { margin-top: 24px; border-top: 1px solid var(--border); }
        .footer-inner { display: flex; justify-content: space-between; gap: 16px; padding-top: 18px; padding-bottom: 18px; color: var(--muted); font-size: 13px; }
        .footer-admin { background: #17212B; border-color: #34424F; }
        .footer-admin .footer-inner { color: #D5DEE7; }
        .footer-job-seeker { background: #EFF6FF; border-color: #BFDBFE; }
        .footer-job-seeker .footer-inner { color: #1E40AF; }
        .footer-company { background: #ECFDF5; border-color: #A7F3D0; }
        .footer-company .footer-inner { color: #065F46; }

        .btn { display: inline-block; border: 1px solid transparent; border-radius: 8px; padding: 10px 18px; font: inherit; font-weight: 600; cursor: pointer; text-align: center; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-primary:hover { background: var(--primary-dark); }
        .btn-outline { background: #fff; color: var(--text); border-color: var(--border); }
        .btn-sm { padding: 6px 14px; font-size: 14px; }
        .btn-block { width: 100%; }

        .card { background: #fff; border: 1px solid var(--border); border-radius: 12px; padding: 24px; box-shadow: 0 1px 2px rgba(15, 23, 42, .05); }
        .card-narrow { max-width: 440px; margin: 24px auto; }
        h1 { font-size: 24px; margin: 0 0 4px; }
        .subtitle { color: var(--muted); margin: 0 0 20px; }

        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: 500; font-size: 14px; margin-bottom: 6px; }
        input[type=text], input[type=email], input[type=password] { width: 100%; padding: 10px 12px; border: 1px solid var(--border); border-radius: 8px; font: inherit; background: #fff; }
        input:focus { outline: 2px solid rgba(37, 99, 235, .3); border-color: var(--primary); }
        .has-error input { border-color: #DC2626; }
        .field-error { color: #DC2626; font-size: 13px; margin-top: 4px; }
        .check { display: flex; align-items: center; gap: 8px; font-size: 14px; }
        .check input { width: auto; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; }
        .alert-success { background: var(--success-bg); color: var(--success-text); }
        .alert-error { background: var(--error-bg); color: var(--error-text); }

        .role-options { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .role-card { display: block; border: 1px solid var(--border); border-radius: 8px; padding: 12px; cursor: pointer; text-align: center; font-weight: 500; margin: 0; }
        .role-card input { display: none; }
        .role-card:has(input:checked) { border-color: var(--primary); background: #EFF6FF; color: var(--primary); }

        .auth-footer { text-align: center; margin: 16px 0 0; font-size: 14px; color: var(--muted); }

        @media (max-width: 600px) {
            .nav-user { display: none; }
            .card { padding: 18px; }
            .footer-inner { flex-direction: column; gap: 4px; }
        }
        @media (max-width: 700px) {
            .dashboard-layout { grid-template-columns: 1fr; gap: 16px; }
        }
    </style>
</head>
<body>
    @hasSection('header')
        @yield('header')
    @else
        <header class="navbar">
            <div class="container nav-inner">
                <a href="/" class="brand">CariKerja</a>
                <nav class="nav-links">
                    @auth
                        @if (auth()->user()->role === 'company')
                            <a href="{{ route('company.dashboard') }}">Dashboard</a>
                        @elseif (auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        @else
                            <a href="{{ route('job-seeker.dashboard') }}">Dashboard</a>
                        @endif
                        <span class="nav-user">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-sm">Keluar</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}">Masuk</a>
                        <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
                    @endauth
                </nav>
            </div>
        </header>
    @endif

    <main class="container main">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">Terdapat kesalahan pada isian Anda. Periksa kembali form di bawah.</div>
        @endif

        @yield('content')
    </main>

    @hasSection('footer')
        @yield('footer')
    @endif

    @stack('scripts')
</body>
</html>