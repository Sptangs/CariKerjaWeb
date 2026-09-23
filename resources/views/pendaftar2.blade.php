@extends('layouts.master2')

@section('title', $title)

@section('content')
    <h3>{{ $title }}</h3>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Pendaftar</th>
                <th>Nama</th>
                <th>Keahlian (Nested Loop)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($paraPendaftar2 as $pendaftar)
            <tr>
                <!-- Menggunakan built-in variable $loop -->
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pendaftar['id'] }}</td>
                <td>{{ $pendaftar['nama'] }}</td>

                <!-- Nested Loop untuk Sub-Array -->
                <td>
                    <ul>
                    @foreach($pendaftar['keahlian'] as $keahlian)
                        <li>{{ $keahlian }}</li>
                    @endforeach
                    </ul>
                </td>

                <td>
                    <!-- Kondisional Bertingkat menggunakan Switch -->
                    @switch($pendaftar['status'])
                        @case('Bekerja')
                            <span style="color: green;">✔ {{ $pendaftar['status'] }}</span>
                            @break
                        @case('Belum Bekerja')
                            <span style="color: orange;">⚙ {{ $pendaftar['status'] }}</span>
                            @break
                        @default
                            <span style="color: red;">✖ {{ $pendaftar['status'] }} (Tidak Tersedia)</span>
                    @endswitch
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data pendaftar saat ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection