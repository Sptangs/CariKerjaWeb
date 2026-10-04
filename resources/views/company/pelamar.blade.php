@extends('layouts.company')

@section('title', 'Pelamar Lowongan')

@section('dashboard-content')
    <h1>Pelamar: {{ $jobPosting->title }}</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Cover Letter</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($applications as $app)
            <tr>
                <td>{{ $app->user->name }}</td>
                <td>{{ $app->user->email }}</td>
                <td>{{ $app->cover_letter }}</td>
                <td>{{ $app->status }}</td>
                <td>
                    @if($app->status === 'pending')
                        <form method="POST" action="{{ route('company.pelamar.terima', $app) }}" style="display:inline">
                            @csrf
                            @method('PUT')
                            <button type="submit">Terima</button>
                        </form>
                        <form method="POST" action="{{ route('company.pelamar.tolak', $app) }}" style="display:inline">
                            @csrf
                            @method('PUT')
                            <button type="submit">Tolak</button>
                        </form>
                    @else
                        <span>{{ $app->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada pelamar</td>
            </tr>
            @endforelse
        </tbody>
    </table>
@endsection