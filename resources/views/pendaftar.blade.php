<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID Pendaftar</th>
            <th>Nama</th>
            <th>Status Pendaftar</th>
        </tr>
    </thead>
    <tbody>
        <!-- Menggunakan Blade Foreach -->
        @foreach ($paraPendaftar as $pendaftar)
        <tr>
            <td>{{ $pendaftar['id'] }}</td>
            <td>{{ $pendaftar['nama'] }}</td>
            <td>
                <!-- Menggunakan Blade If-Else untuk kondisional -->
            
                @if($pendaftar['status'] == 'Sudah Bekerja')
                    <span style="color: green; font-weight: bold;">{{ $pendaftar['status'] }}</span>
                @else
                    <span style="color: red; text-decoration: line-through;">{{ $pendaftar['status'] }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>