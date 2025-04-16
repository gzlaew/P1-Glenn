<!DOCTYPE html>
<html>
<head>
    <title>Data Pegawai - PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h3>Data Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>No HP</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->phone_number }}</td>
                <td>{{ $user->birth_date }}</td>
                <td>{{ $user->address }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
