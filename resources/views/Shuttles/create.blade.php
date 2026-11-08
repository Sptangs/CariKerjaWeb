<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl bg-white p-8">
        <h1 class="text-2xl font-bold mb-6 text-center">
            Tambah Data Shuttle
        </h1>

        <form action="{{ route('shuttles.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label for="nama_armada" class="block mb-2">
                    Nama Armada
                </label>
                <input
                    type="text"
                    id="nama_armada"
                    name="nama_armada"
                    value="{{ old('nama_armada') }}"
                    class="w-full border border-gray-300 p-3"
                >
                @error('nama_armada')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="kapasitas" class="block mb-2">
                    Kapasitas
                </label>
                <input
                    type="number"
                    id="kapasitas"
                    name="kapasitas"
                    value="{{ old('kapasitas') }}"
                    class="w-full border border-gray-300 p-3"
                >
                @error('kapasitas')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="rute_operasional" class="block mb-2">
                    Rute Operasional
                </label>
                <input
                    type="text"
                    id="rute_operasional"
                    name="rute_operasional"
                    value="{{ old('rute_operasional') }}"
                    class="w-full border border-gray-300 p-3"
                >
                @error('rute_operasional')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center gap-3">
                <button
                    type="submit"
                    class="bg-blue-600 text-white px-6 py-3 hover:bg-blue-700"
                >
                    Simpan Data
                </button>

                <a
                    href="{{ route('shuttles.index') }}"
                    class="border border-gray-300 px-6 py-3 hover:bg-gray-100"
                >
                    Kembali
                </a>
            </div>
        </form>
    </div>

</body>
</html>