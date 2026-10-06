<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Perusahaan') - CariKerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="flex min-h-screen">
        {{-- sidebar --}}
            <aside class="w-64 bg-[#0F172A] border-r border-slate-200 flex flex-col">
            <div class="p-6 border-b border-slate-200">
                <h1 class="text-xl font-bold text-white">CariKerja</h1>
                <p class="text-xs text-slate-500 mt-1">PT Teknologi Maju</p>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('company.dashboard') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('company.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('company.profile') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('company.profile') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Profil Perusahaan
                </a>
                <a href="{{ route('company.lowongan') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('company.lowongan') && !request()->routeIs('company.lowongan.create') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Lowongan Saya
                </a>
                <a href="{{ route('company.lowongan.create') }}"
                   class="block px-4 py-2.5 rounded-lg text-sm font-medium transition
                   {{ request()->routeIs('company.lowongan.create') ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Buat Lowongan
                </a>
            </nav>

            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-600 hover:bg-slate-100 rounded-lg">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        {{-- konten --}}
        <div class="flex-1 flex flex-col">
            {{-- header --}}
            <header class="bg-white border-b border-slate-200 px-8 py-4 flex justify-end">
                <span class="text-sm text-slate-600">{{ auth()->user()->name }}</span>
            </header>

            {{-- konten --}}
            <main class="flex-1 p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg bg-emerald-50 border border-emerald-200 p-4 text-sm text-emerald-700">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('dashboard-content')
            </main>
        </div>
    </div>
</body>
</html>