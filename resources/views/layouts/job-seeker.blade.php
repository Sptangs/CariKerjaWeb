<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Pencari Kerja') - CariKerja</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">

        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

            {{-- Brand --}}
            <a
                href="{{ route('job-seeker.dashboard') }}"
                class="flex items-center gap-2">
                <span class="text-xl font-extrabold tracking-tight text-indigo-600">
                    CariKerja
                </span>

                <span class="rounded-md bg-indigo-100 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-indigo-700">
                    KARIER
                </span>
            </a>

            <nav class="flex items-center gap-1" aria-label="Navigasi pencari kerja">

                {{-- Home --}}
                <a
                    href="{{ route('job-seeker.dashboard') }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold transition
                {{ request()->routeIs('job-seeker.dashboard')
                    ? 'bg-indigo-50 text-indigo-700'
                    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Home
                </a>


                {{-- Lowongan --}}
                <a
                    href="{{ route('job-seeker.lowongan') }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold transition
                {{ request()->routeIs('job-seeker.lowongan')
                    ? 'bg-indigo-50 text-indigo-700'
                    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Lowongan
                </a>


                {{-- Riwayat Lamaran --}}
                <a
                    href="{{ route('job-seeker.riwayat') }}"
                    class="rounded-lg px-4 py-2 text-sm font-semibold transition
                {{ request()->routeIs('job-seeker.riwayat')
                    ? 'bg-indigo-50 text-indigo-700'
                    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Riwayat Lamaran
                </a>


                {{-- Profile --}}
                <div
                    class="relative ml-2"
                    x-data="{ open: false }"
                    @click.outside="open = false">

                    <button
                        type="button"
                        @click="open = !open"
                        class="flex h-10 w-10 items-center justify-center rounded-full
                           bg-linear-to-br from-indigo-500 to-blue-600
                           text-sm font-bold text-white
                           shadow-sm shadow-indigo-200
                           transition hover:scale-105 hover:shadow-md
                           focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </button>


                    {{-- Dropdown --}}
                    <div
                        x-show="open"
                        x-transition
                        class="absolute right-0 mt-3 w-72 overflow-hidden rounded-2xl
                           border border-slate-200 bg-white shadow-xl"
                        style="display: none;">

                        {{-- User --}}
                        <div class="bg-linear-to-r from-indigo-50 to-blue-50 px-5 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-11 w-11 items-center justify-center rounded-full
                                        bg-linear-to-br from-indigo-500 to-blue-600
                                        font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-slate-900">
                                        {{ auth()->user()->name }}
                                    </p>

                                    <p class="truncate text-xs text-slate-500">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- Dropdown Menu --}}
                        <div class="p-2">

                            {{-- Profile --}}
                            <a
                                href="{{ route('job-seeker.profile') }}"
                                class="flex items-center gap-3 rounded-xl px-3 py-3
                                   text-sm font-medium text-slate-700
                                   transition hover:bg-indigo-50 hover:text-indigo-700">
                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100">
                                    <svg
                                        class="h-5 w-5 text-slate-500"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M20 21a8 8 0 0 0-16 0" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                </div>

                                <div>
                                    <p>Profil Saya</p>
                                    <p class="text-xs font-normal text-slate-400">
                                        Kelola informasi profil
                                    </p>
                                </div>
                            </a>


                            <div class="my-2 border-t border-slate-100"></div>


                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="flex w-full items-center gap-3 rounded-xl px-3 py-3
                                       text-left text-sm font-medium text-red-600
                                       transition hover:bg-red-50">
                                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50">
                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" y1="12" x2="9" y2="12" />
                                        </svg>
                                    </div>

                                    <div>
                                        <p>Keluar</p>
                                        <p class="text-xs font-normal text-red-400">
                                            Keluar dari akun
                                        </p>
                                    </div>
                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            </nav>

        </div>

    </header>

    {{-- =========================================================
        MAIN
    ========================================================== --}}
    <main class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Success Alert --}}
        @if (session('success'))

        <div
            class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200
                       bg-emerald-50 px-4 py-4 text-sm text-emerald-700 shadow-sm"
            role="alert">

            <div class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-100">
                <svg
                    class="h-4 w-4 text-emerald-600"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <path d="m5 12 5 5L20 7" />
                </svg>
            </div>

            <div>
                <p class="font-semibold">Berhasil</p>
                <p class="mt-0.5 text-emerald-600">
                    {{ session('success') }}
                </p>
            </div>

        </div>

        @endif

        <div class="flex flex-col gap-6 lg:flex-row">


            <section class="min-w-0 flex-1">

                @yield('dashboard-content')

            </section>

        </div>

    </main>


    <footer class="mt-auto border-t border-slate-200 bg-white">

        <div
            class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-6
                   text-sm sm:flex-row sm:items-center sm:justify-between
                   sm:px-6 lg:px-8">

            <div>
                <p class="font-bold text-slate-900">
                    CariKerja
                </p>

                <p class="mt-0.5 text-xs text-slate-400">
                    Platform pencarian kerja
                </p>
            </div>

            <p class="text-xs text-slate-500">
                Temukan dan pantau peluang karier Anda di CariKerja.
            </p>

        </div>

    </footer>

</body>

</html>