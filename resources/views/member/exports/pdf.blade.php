<!DOCTYPE html>
<html>
<head>
    <title>Data Member</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Data Member</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Saldo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $i => $member)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $member->nama }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->no_hp }}</td>
                    <td>{{ number_format($member->saldo) }}</td>
                    <td>{{ ucfirst($member->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
