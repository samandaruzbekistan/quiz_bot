<table>
    <thead>
    <tr>
        <th>F.I.SH</th>
        <th>To'gri javob</th>
        <th>Noto'g'ri javob</th>
        <th>Maktab</th>
        <th>Sinf</th>
        <th>Viloyat</th>
        <th>Tuman</th>
        <th>Mahalla</th>
        <th>Telefon</th>
        <!-- Add more columns as needed -->
    </tr>
    </thead>
    <tbody>
    @foreach($results as $result)
        <tr>
            <td>{{ $result->name }}</td>
            <td>{{ $result->correct }}</td>
            <td>{{ $result->incorrect }}</td>
            <td>{{ $result->school }}</td>
            <td>{{ $result->class }}</td>
            <td>{{ $result->region }}</td>
            <td>{{ $result->district }}</td>
            <td>{{ $result->quarter }}</td>
            <td>{{ $result->phone }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
