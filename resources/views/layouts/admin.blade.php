<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Admin') - CariKerja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">
    <div x-data="{ sidebarOpen: false, profileOpen: false }" class="min-h-screen">

        {{-- Overlay sidebar (mobile) --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"
            style="display: none;"
            @click="sidebarOpen = false">
        </div>

        <div class="flex min-h-screen">

            {{-- =========================================================
                SIDEBAR
            ========================================================== --}}
            <aside
                class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-slate-900 transition-transform duration-300 ease-in-out lg:sticky lg:top-0 lg:h-screen"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

                {{-- Brand --}}
                <div class="flex h-16 shrink-0 items-center justify-between border-b border-white/10 px-5">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-linear-to-br from-indigo-500 to-blue-600 text-sm font-black text-white shadow-lg shadow-indigo-900/40">
                            CK
                        </span>
                        <span class="flex flex-col leading-tight">
                            <span class="text-lg font-extrabold tracking-tight text-white">CariKerja</span>
                            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-400">
                                Admin Panel
                            </span>
                        </span>
                    </a>

                    <button
                        type="button"
                        class="rounded-lg p-2 text-slate-400 transition hover:bg-white/5 hover:text-white lg:hidden"
                        aria-label="Tutup menu"
                        @click="sidebarOpen = false">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6 6 18M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Navigation --}}
                <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-5" aria-label="Navigasi admin">
                    <p class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">
                        Menu Utama
                    </p>

                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.dashboard')
                            ? 'bg-linear-to-r from-indigo-500 to-blue-600 text-white shadow-lg shadow-indigo-900/30'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                        @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg transition
                            {{ request()->routeIs('admin.dashboard')
                                ? 'bg-white/15 text-white'
                                : 'bg-white/5 text-slate-400 group-hover:text-white' }}">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" rx="1.5" />
                                <rect x="14" y="3" width="7" height="7" rx="1.5" />
                                <rect x="3" y="14" width="7" height="7" rx="1.5" />
                                <rect x="14" y="14" width="7" height="7" rx="1.5" />
                            </svg>
                        </span>
                        <span>Ringkasan</span>
                        @if (request()->routeIs('admin.dashboard'))
                            <span class="ml-auto h-1.5 w-1.5 rounded-full bg-white"></span>
                        @endif
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                        class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('admin.users.*')
                            ? 'bg-linear-to-r from-indigo-500 to-blue-600 text-white shadow-lg shadow-indigo-900/30'
                            : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                        @if (request()->routeIs('admin.users.*')) aria-current="page" @endif>
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg transition
                            {{ request()->routeIs('admin.users.*')
                                ? 'bg-white/15 text-white'
                                : 'bg-white/5 text-slate-400 group-hover:text-white' }}">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </span>
                        <span>Pengguna</span>
                        @if (request()->routeIs('admin.users.*'))
                            <span class="ml-auto h-1.5 w-1.5 rounded-full bg-white"></span>
                        @endif
                    </a>

                    <p class="px-3 pt-5 pb-2 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-500">
                        Segera Hadir
                    </p>

                    <div class="flex cursor-not-allowed items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-500">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/5">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" />
                            </svg>
                        </span>
                        <span>Perusahaan</span>
                        <span class="ml-auto rounded-full bg-white/5 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                            Soon
                        </span>
                    </div>

                    <div class="flex cursor-not-allowed items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-500">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/5">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="7" width="18" height="13" rx="2" />
                                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18" />
                            </svg>
                        </span>
                        <span>Lowongan</span>
                        <span class="ml-auto rounded-full bg-white/5 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide">
                            Soon
                        </span>
                    </div>
                </nav>

                {{-- Admin card --}}
                <div class="shrink-0 border-t border-white/10 p-3">
                    <div class="flex items-center gap-3 rounded-xl bg-white/5 p-3">
                        <span
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-linear-to-br from-indigo-500 to-blue-600 text-sm font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-400">Administrator</p>
                        </div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                title="Keluar"
                                class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-400 transition hover:bg-red-500/10 hover:text-red-400">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            {{-- =========================================================
                MAIN COLUMN
            ========================================================== --}}
            <div class="flex min-h-screen min-w-0 flex-1 flex-col">

                {{-- Header --}}
                <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/85 backdrop-blur">
                    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

                        <div class="flex min-w-0 items-center gap-3">
                            <button
                                type="button"
                                class="rounded-lg p-2 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900 lg:hidden"
                                aria-label="Buka menu"
                                @click="sidebarOpen = true">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2">
                                    <path d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>

                            <div class="min-w-0">
                                <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-indigo-500">
                                    Panel Administrator
                                </p>
                                <h1 class="truncate text-lg font-bold text-slate-900">
                                    @yield('title', 'Dashboard Admin')
                                </h1>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 sm:gap-3">
                            <span
                                class="hidden items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700 sm:flex">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Sistem normal
                            </span>

                            {{-- Profile dropdown --}}
                            <div class="relative" @click.outside="profileOpen = false">
                                <button
                                    type="button"
                                    class="flex items-center gap-2.5 rounded-full py-1.5 pl-1.5 pr-2 transition hover:bg-slate-100"
                                    @click="profileOpen = !profileOpen">
                                    <span
                                        class="flex h-9 w-9 items-center justify-center rounded-full bg-linear-to-br from-indigo-500 to-blue-600 text-sm font-bold text-white shadow-sm shadow-indigo-200">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </span>

                                    <span class="hidden text-left sm:block">
                                        <span class="block max-w-[160px] truncate text-sm font-semibold text-slate-800">
                                            {{ auth()->user()->name }}
                                        </span>
                                        <span class="block text-xs text-slate-400">Administrator</span>
                                    </span>

                                    <svg class="hidden h-4 w-4 text-slate-400 sm:block" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </button>

                                <div
                                    x-show="profileOpen"
                                    x-transition
                                    class="absolute right-0 mt-3 w-72 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl"
                                    style="display: none;">

                                    <div class="bg-linear-to-r from-indigo-50 to-blue-50 px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="flex h-11 w-11 items-center justify-center rounded-full bg-linear-to-br from-indigo-500 to-blue-600 font-bold text-white">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                            </span>
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

                                    <div class="p-2">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-medium text-slate-700 transition hover:bg-indigo-50 hover:text-indigo-700">
                                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100">
                                                <svg class="h-5 w-5 text-slate-500" viewBox="0 0 24 24"
                                                    fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="3" y="3" width="7" height="7" rx="1.5" />
                                                    <rect x="14" y="3" width="7" height="7" rx="1.5" />
                                                    <rect x="3" y="14" width="7" height="7" rx="1.5" />
                                                    <rect x="14" y="14" width="7" height="7" rx="1.5" />
                                                </svg>
                                            </span>
                                            <span>Kembali ke Ringkasan</span>
                                        </a>

                                        <div class="my-2 border-t border-slate-100"></div>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50">
                                                <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2">
                                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                                        <polyline points="16 17 21 12 16 7" />
                                                        <line x1="21" y1="12" x2="9" y2="12" />
                                                    </svg>
                                                </span>
                                                <span>Keluar</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                {{-- Content --}}
                <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                    <div class="mx-auto w-full max-w-7xl">

                        @if (session('success'))
                            <div class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-700 shadow-sm"
                                role="alert">
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-100">
                                    <svg class="h-4 w-4 text-emerald-600" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="m5 12 5 5L20 7" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold">Berhasil</p>
                                    <p class="mt-0.5 text-emerald-600">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-5 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-700 shadow-sm"
                                role="alert">
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-100">
                                    <svg class="h-4 w-4 text-rose-600" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M12 9v4M12 17h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold">Terjadi kesalahan</p>
                                    <p class="mt-0.5 text-rose-600">{{ session('error') }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-5 flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-700 shadow-sm"
                                role="alert">
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-rose-100">
                                    <svg class="h-4 w-4 text-rose-600" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2">
                                        <path d="M12 9v4M12 17h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z" />
                                    </svg>
                                </span>
                                <div>
                                    <p class="font-semibold">Periksa kembali input Anda</p>
                                    <p class="mt-0.5 text-rose-600">{{ $errors->first() }}</p>
                                </div>
                            </div>
                        @endif

                        @yield('dashboard-content')

                    </div>
                </main>

                {{-- Footer --}}
                <footer class="border-t border-slate-200 bg-white">
                    <div
                        class="mx-auto flex w-full max-w-7xl flex-col gap-3 px-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                        <div class="flex items-center gap-2.5">
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-lg bg-linear-to-br from-indigo-500 to-blue-600 text-xs font-black text-white">
                                CK
                            </span>
                            <div>
                                <p class="text-sm font-bold text-slate-900">CariKerja</p>
                                <p class="text-xs text-slate-400">Panel Administrator</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1 text-xs text-slate-500 sm:items-end">
                            <p>&copy; {{ date('Y') }} CariKerja. Semua hak dilindungi.</p>
                            <p class="flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Sistem berjalan normal
                            </p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>
