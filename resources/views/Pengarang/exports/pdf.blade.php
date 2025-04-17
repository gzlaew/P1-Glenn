<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pengarang</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      line-height: 1.4;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    th, td {
      border: 1px solid #999;
      padding: 6px 10px;
      text-align: left;
    }
    th {
      background-color: #eee;
    }
    h2 {
      margin-bottom: 0;
    }
    p {
      margin-top: 0;
    }
  </style>
</head>
<body>
  <h2>Data Pengarang</h2>
  <p>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</p>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Pengarang</th>
        <th>Tanggal Dibuat</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pengarangList as $i => $item)
        <tr>
          <td>{{ $i + 1 }}</td>
          <td>{{ $item->nama_pengarang }}</td>
          <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
