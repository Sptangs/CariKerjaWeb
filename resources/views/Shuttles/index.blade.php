<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
        <h1 class="text-2xl font-bold mb-6">Data Shuttle</h1>

        <a href="{{ route('shuttles.create') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded mb-5">
            + Tambah Shuttle
        </a>

        <table class="w-full border-collapse border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3">No.</th>
                    <th class="border p-3">Nama Armada</th>
                    <th class="border p-3">Kapasitas</th>
                    <th class="border p-3">Rute Operasional</th>
                    <th class="border p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shuttles as $shuttle)
                    <tr>
                        <td class="border p-3">{{ $loop->iteration }}</td>
                        <td class="border p-3">{{ $shuttle->nama_armada }}</td>
                        <td class="border p-3">{{ $shuttle->kapasitas }}</td>
                        <td class="border p-3">{{ $shuttle->rute_operasional }}</td>
                        <td class="border p-3">
                            <a href="{{ route('shuttles.edit', $shuttle->id) }}"
                               class="text-blue-600 hover:underline">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="border p-3 text-center">
                            Belum ada data shuttle.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>