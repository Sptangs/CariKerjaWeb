<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') - CariKerja</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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
        body { margin: 0; font-family: 'Inter', system-ui, sans-serif; background: var(--bg); color: var(--text); line-height: 1.5; }
        a { color: var(--primary); text-decoration: none; }
        .container { width: 100%; max-width: 1100px; margin: 0 auto; padding: 0 16px; }
        .main { padding-top: 24px; padding-bottom: 48px; }

        .navbar { background: #fff; border-bottom: 1px solid var(--border); }
        .nav-inner { display: flex; align-items: center; justify-content: space-between; height: 64px; }
        .brand { font-size: 20px; font-weight: 700; color: var(--primary); }
        .nav-links { display: flex; align-items: center; gap: 16px; }
        .nav-links form { margin: 0; }
        .nav-user { color: var(--muted); font-size: 14px; }

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
        }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="container nav-inner">
            <a href="/" class="brand">CariKerja</a>
            <nav class="nav-links">
                @auth
                    @if (auth()->user()->role === 'company')
                        <a href="{{ route('company.dashboard') }}">Dashboard</a>
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

    <main class="container main">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">Terdapat kesalahan pada isian Anda. Periksa kembali form di bawah.</div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>