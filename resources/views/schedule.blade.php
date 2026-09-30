<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID Bus</th>
            <th>Rute Perjalanan</th>
            <th>Status Operasional</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jadwalBus as $bus)
        <tr>
            <td>{{ $bus['id'] }}</td>
            <td>{{ $bus['rute'] }}</td>
            <td>
                @if($bus['status'] == 'Beroperasi')
                    <span style="color: green; font-weight: bold;">{{ $bus['status'] }}</span>
                @else
                    <span style="color: red; text-decoration: line-through;">{{ $bus['status'] }}</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>