<!DOCTYPE html>
<html lang="id">
<head>
    <title>@yield('title', 'Aplikasi PjBL')</title>
</head>
<body>
    <header>
        <h2>Sistem Cari Kerja Web</h2>
        <hr>
    </header>

    <main>
        <!-- Konten dinamis akan masuk ke sini -->
        @yield('content')
    </main>

    <footer>
        <p>&copy; 2026 Proyek PjBL Kelompok</p>
    </footer>
</body>
</html>