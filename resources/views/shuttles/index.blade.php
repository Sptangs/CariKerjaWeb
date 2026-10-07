<!-- Form Pencarian dengan method GET -->
<form action="{{ route('shuttles.index') }}" method="GET" style="margin-bottom: 15px;">
    <input type="text" name="search" placeholder="Cari nama pekerja..." value="{{ request('search') }}">
    <button type="submit">Cari</button>
</form>

<table border="1" cellpadding="10" cellspacing="0" style="margin-top: 15px;">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pekerja</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($shuttles as $index => $shuttle)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $shuttle->nama }}</td>
                <td>
                    <a href="{{ route('shuttles.edit', $shuttle->id) }}">Edit</a>

                    <!-- Form Tombol Hapus dengan Method Spoofing -->
                    <form action="{{ route('shuttles.destroy', $shuttle->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align: center;">Tidak ada data armada ditemukan.</td>
            </tr>
        @endforelse
    </tbody>
    <a href="{{ route('shuttles.create') }}" style="padding: 5px 10px; background-color: white; color: blue; text-decoration: none;">+ Tambah Data Shuttle</a>
</table>