<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Data Penerbit</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #444;
        }

        th {
            background-color: #f2f2f2;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        h2 {
            text-align: center;
            margin-bottom: 5px;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 11px;
        }
    </style>
</head>
<body>
    <h2>Data Penerbit</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penerbit</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penerbitList as $index => $penerbit)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $penerbit->nama_penerbit }}</td>
                    <td>{{ \Carbon\Carbon::parse($penerbit->created_at)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
