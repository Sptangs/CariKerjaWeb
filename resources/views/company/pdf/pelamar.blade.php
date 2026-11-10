<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pelamar</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Daftar Pelamar Lowongan: {{ $jobPosting->title }}</h1>
    <p>Perusahaan: {{ $jobPosting->company->company_name }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelamar</th>
                <th>Email</th>
                <th>Tanggal Melamar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $index => $app)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $app->user->name }}</td>
                <td>{{ $app->user->email }}</td>
                <td>{{ $app->created_at->format('d M Y') }}</td>
                <td>{{ ucfirst($app->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>