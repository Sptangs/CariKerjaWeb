<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shuttle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6">Edit Data Shuttle</h1>

        <form action="{{ route('shuttles.update', $shuttle->id) }}"
            method="POST">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label for="nama_armada" class="block mb-2 font-medium">
                    Nama Armada
                </label>
                <input
                    type="text"
                    id="nama_armada"
                    name="nama_armada"
                    value="{{ old('nama_armada', $shuttle->nama_armada) }}"
                    class="w-full border rounded-lg p-3">

                @error('nama_armada')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="kapasitas" class="block mb-2 font-medium">
                    Kapasitas
                </label>
                <input
                    type="number"
                    id="kapasitas"
                    name="kapasitas"
                    value="{{ old('kapasitas', $shuttle->kapasitas) }}"
                    class="w-full border rounded-lg p-3">

                @error('kapasitas')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="rute_operasional" class="block mb-2 font-medium">
                    Rute Operasional
                </label>
                <input
                    type="text"
                    id="rute_operasional"
                    name="rute_operasional"
                    value="{{ old('rute_operasional', $shuttle->rute_operasional) }}"
                    class="w-full border rounded-lg p-3">

                @error('rute_operasional')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button
                type="submit"
                class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700">
                Perbarui Data
            </button>

            <a href="{{ route('shuttles.index') }}"
                class="ml-2 text-gray-600 hover:underline">
                Kembali
            </a>
        </form>
    </div>

</body>

</html>