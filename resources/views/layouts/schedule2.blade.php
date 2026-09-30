@extends('layouts.master2')

@section('title', $title)

@section('content')
    <h3>{{ $title }}</h3>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Bus</th>
                <th>Rute Perjalanan</th>
                <th>Fasilitas (Nested Loop)</th>
                <th>Status Operasional</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwalBus as $bus)
            <tr>
                <!-- Menggunakan built-in variable $loop -->
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bus['id'] }}</td>
                <td>{{ $bus['rute'] }}</td>

                <!-- Nested Loop untuk Sub-Array -->
                <td>
                    <ul>
                    @foreach($bus['fasilitas'] as $fitur)
                        <li>{{ $fitur }}</li>
                    @endforeach
                    </ul>
                </td>

                <td>
                    <!-- Kondisional Bertingkat menggunakan Switch -->
                    @switch($bus['status'])
                        @case('Beroperasi')
                            <span style="color: green;">✔ {{ $bus['status'] }}</span>
                            @break
                        @case('Maintenance')
                            <span style="color: orange;">⚙ {{ $bus['status'] }}</span>
                            @break
                        @default
                            <span style="color: red;">✖ {{ $bus['status'] }} (Tidak Tersedia)</span>
                    @endswitch
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data jadwal transportasi saat ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection